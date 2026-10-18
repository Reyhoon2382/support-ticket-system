<?php

namespace App\Http\Controllers;

use App\Enums\DepartmentEnum;
use App\Enums\TicketStatusEnum;
use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\User;
use App\Notifications\TicketAssignedNotification;
use App\Notifications\TicketCreatedNotification;
use App\Notifications\TicketStatusChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Ticket::query();

        // Customer → only own
        if ($user->isCustomer()) {
            $query->where('user_id', $user->id);

            // Expert → only assigned tickets
        } elseif ($user->isExpert()) {
            $query->whereHas('assignments', function ($q) use ($user) {
                $q->where('assigned_to', $user->id);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('ticket_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Department
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $tickets = $query->latest()->paginate(15)->withQueryString();

        $statuses = TicketStatusEnum::cases();
        $departments = DepartmentEnum::cases();

        return view('tickets.index', compact('tickets', 'statuses', 'departments'));
    }

    public function create()
    {
        $departments = DepartmentEnum::cases();
        return view('tickets.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'department' => 'required|string',
        ]);

        $ticket = Ticket::create([
            'ticket_number' => 'TCK-' . strtoupper(Str::random(8)),
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'department' => $request->department,
            'status' => TicketStatusEnum::NEW->value,
            'priority' => 'normal',
        ]);

        User::whereIn('role', [\App\Enums\UserRoleEnum::ADMIN, \App\Enums\UserRoleEnum::SUPPORT_MANAGER])
            ->get()
            ->each(function ($user) use ($ticket) {
                $user->notify(new TicketCreatedNotification($ticket));
            });

        return redirect()->route('tickets.index')->with('success', 'تیکت با موفقیت ایجاد شد.');
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        $ticket->load(['messages.user', 'assignments', 'statusLogs']);

        return view('tickets.show', compact('ticket'));
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->user->notifications()->where('data->ticket_id', $ticket->id)->delete();

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'تیکت با موفقیت حذف شد.');
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $user = auth()->user();

        $this->authorize('assign', $ticket);

        $request->validate([
            'assigned_to' => ['required', \Illuminate\Validation\Rule::exists('users', 'id')->where('role', 'expert')],
        ]);

        $oldAssignment = $ticket->assignments()->latest()->first();
        if ($oldAssignment && $oldAssignment->assigned_to != $request->assigned_to) {
            $oldExpert = \App\Models\User::find($oldAssignment->assigned_to);

            if ($oldExpert) {
                $oldExpert->notifications()->where('data->ticket_id', $ticket->id)->delete();
            }
        }

        TicketAssignment::create([
            'ticket_id' => $ticket->id,
            'assigned_by' => $user->id,
            'assigned_to' => $request->assigned_to,
            'department' => $ticket->department->value,
            'note' => $request->note ?? null,
        ]);

        $expert = \App\Models\User::findOrFail($request->assigned_to);

        $expert->notify(new TicketAssignedNotification($ticket));

        $oldStatus = $ticket->status->value;

        if (!$oldAssignment || $oldAssignment->assigned_to != $request->assigned_to) {
            $ticket->update([
                'status' => TicketStatusEnum::ASSIGNED->value,
            ]);
        }

        // ثبت لاگ SQL

        $ticket->statusLogs()->create([
            'changed_by' => $user->id,
            'old_status' => $oldStatus,
            'new_status' => TicketStatusEnum::ASSIGNED->value,
            'note' => 'تیکت اختصاص داده شد',
        ]);

        // ثبت لاگ MongoDB
        ActivityLog::create([
            'ticket_id' => $ticket->id,
            'action' => 'assigned',
            'performed_by' => $user->id,
            'old_value' => $oldStatus,
            'new_value' => TicketStatusEnum::ASSIGNED->value,
            'meta' => [
                'assigned_to' => $request->assigned_to,
            ],
        ]);

        return back()->with('success', 'تیکت با موفقیت اختصاص داده شد.');
    }

    public function changeStatus(Request $request, Ticket $ticket)
    {
        $user = auth()->user();

        $this->authorize('changeStatus', $ticket);

        if ($user->isExpert()) {
            $allowedStatuses = [TicketStatusEnum::UNDER_REVIEW->value, TicketStatusEnum::IN_PROGRESS->value, TicketStatusEnum::WAITING_FOR_CUSTOMER->value, TicketStatusEnum::RESOLVED->value];

            $request->validate([
                'status' => ['required', 'in:' . implode(',', $allowedStatuses)],
                'result' => 'nullable|string',
            ]);
        } else {
            $request->validate([
                'status' => ['required', Rule::enum(TicketStatusEnum::class)],
                'result' => 'nullable|string',
            ]);
        }

        $oldStatus = $ticket->status->value;

        $ticket->update([
            'status' => $request->status,
            'closed_at' => $request->status === 'closed' ? now() : null,
        ]);
        if ($oldStatus !== $request->status) {
            $ticket->user->notify(new TicketStatusChangedNotification($ticket, $oldStatus));
        }

        //SQL log

        $ticket->statusLogs()->create([
            'changed_by' => $user->id,
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'result' => $request->result,
        ]);

        //MongoDB log

        ActivityLog::create([
            'ticket_id' => $ticket->id,
            'action' => 'status_changed',
            'performed_by' => $user->id,
            'old_value' => $oldStatus,
            'new_value' => $request->status,
            'meta' => [
                'result' => $request->result,
            ],
        ]);

        return back()->with('success', 'وضعیت با موفقیت به‌روزرسانی شد.');
    }
}
