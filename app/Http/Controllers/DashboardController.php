<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isExpert()) {
            $assignedTicketIds = Ticket::whereHas('assignments', function ($query) use ($user) {
                $query->where('assigned_to', $user->id)->whereNotExists(function ($subQuery) {
                    $subQuery->selectRaw('1')->from('ticket_assignments as newer_assignment')->whereColumn('newer_assignment.ticket_id', 'ticket_assignments.ticket_id')->whereColumn('newer_assignment.id', '>', 'ticket_assignments.id');
                });
            })->pluck('id');

            $allAssignedTickets = Ticket::whereIn('id', $assignedTicketIds)->get();

            // Search + Status Filter
            if ($request->filled('search')) {
                $searchIds = Ticket::search($request->search)->keys();

                $assignedTickets = Ticket::whereIn('id', $assignedTicketIds)
                    ->whereIn('id', $searchIds)
                    ->when($request->filled('status'), function ($query) use ($request) {
                        $query->where('status', $request->status);
                    })
                    ->latest()
                    ->get();
            } else {
                $assignedTickets = Ticket::whereIn('id', $assignedTicketIds)
                    ->when($request->filled('status'), function ($query) use ($request) {
                        $query->where('status', $request->status);
                    })
                    ->latest()
                    ->get();
            }

            // Statistics
            $assignedTotal = $allAssignedTickets->count();

            $newTickets = $allAssignedTickets->where('status', TicketStatusEnum::NEW)->count();

            $inProgressTickets = $allAssignedTickets->where('status', TicketStatusEnum::IN_PROGRESS)->count();

            $waitingForCustomerTickets = $allAssignedTickets->where('status', TicketStatusEnum::WAITING_FOR_CUSTOMER)->count();

            $resolvedTickets = $allAssignedTickets->where('status', TicketStatusEnum::RESOLVED)->count();

            return view('expert.dashboard', compact('assignedTickets', 'assignedTotal', 'inProgressTickets', 'waitingForCustomerTickets', 'resolvedTickets'));
        }

        if ($user->isCustomer()) {
            $customerTickets = Ticket::where('user_id', $user->id);

            $totalTickets = (clone $customerTickets)->count();

            $newTickets = (clone $customerTickets)->where('status', TicketStatusEnum::NEW->value)->count();

            $inProgressTickets = (clone $customerTickets)->where('status', TicketStatusEnum::IN_PROGRESS->value)->count();

            $resolvedTickets = (clone $customerTickets)->where('status', TicketStatusEnum::RESOLVED->value)->count();

            $recentTickets = (clone $customerTickets)->with('messages')->latest()->limit(5)->get();

            return view('customer.dashboard', compact('totalTickets', 'newTickets', 'inProgressTickets', 'resolvedTickets', 'recentTickets'));
        }

        $totalTickets = Ticket::count();
        $totalUsers = User::count();

        $totalCustomers = User::where('role', UserRoleEnum::CUSTOMER->value)->count();

        $totalExperts = User::where('role', UserRoleEnum::EXPERT->value)->count();

        $totalSupportManagers = User::where('role', UserRoleEnum::SUPPORT_MANAGER->value)->count();

        $openTickets = Ticket::where('status', TicketStatusEnum::NEW->value)->count();

        $pendingTickets = Ticket::where('status', TicketStatusEnum::ASSIGNED->value)->count();

        $closedTickets = Ticket::whereNotNull('closed_at')->count();

        $todayTickets = Ticket::whereDate('created_at', Carbon::today())->count();

        $waitingTickets = Ticket::where('status', TicketStatusEnum::ASSIGNED->value)->count();

        $avgCloseTime = Ticket::whereNotNull('closed_at')->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, closed_at)) as avg')->value('avg');

        $dailyTickets = Ticket::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($ticket) {
                $ticket->date = Jalalian::fromDateTime($ticket->date)->format('Y/m/d');
                return $ticket;
            });

        $statusChart = Ticket::selectRaw('status, COUNT(*) as count')->groupBy('status')->get();

        $activityLogs = ActivityLog::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$action',
                        'count' => [
                            '$sum' => 1,
                        ],
                    ],
                ],

                [
                    '$sort' => [
                        'count' => -1,
                    ],
                ],
            ]);
        });

        $activityLogs = collect($activityLogs)->map(function ($item) {
            return [
                'action' => $item['_id'],
                'count' => $item['count'],
            ];
        });

        $recentActivities = ActivityLog::orderByDesc('created_at')->limit(10)->get();

        $performedByIds = $recentActivities->pluck('performed_by')->filter()->unique()->values();

        $performedByUsers = User::whereIn('id', $performedByIds)->pluck('name', 'id');

        $recentActivities->each(function ($activity) use ($performedByUsers) {
            $activity->performed_by_name = $performedByUsers[$activity->performed_by] ?? 'کاربر سیستم';
        });

        if ($user->isSupportManager()) {
            return view('manager.dashboard', compact('totalTickets', 'openTickets', 'pendingTickets', 'closedTickets', 'todayTickets', 'waitingTickets', 'avgCloseTime', 'dailyTickets', 'activityLogs', 'statusChart', 'recentActivities'));
        }

        return view('dashboard', compact('totalTickets', 'openTickets', 'pendingTickets', 'closedTickets', 'todayTickets', 'waitingTickets', 'avgCloseTime', 'dailyTickets', 'activityLogs', 'statusChart', 'recentActivities', 'totalUsers', 'totalCustomers', 'totalExperts', 'totalSupportManagers'));
    }
}
