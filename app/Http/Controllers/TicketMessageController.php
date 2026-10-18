<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Notifications\CustomerRepliedNotification;
use App\Notifications\ExpertRepliedNotification;
use App\Notifications\SupportManagerRepliedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketMessageController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $this->authorize('reply', $ticket);
        $request->validate([
            'message' => 'required|string',
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_internal' => false,
        ]);

        if (Auth::user()->isExpert()) {
            $ticket->user->notify(new ExpertRepliedNotification($ticket));
        }

        if (Auth::user()->isCustomer()) {
            $expert = $ticket->assignments()->latest()->first()?->assignedTo;

            if ($expert) {
                $expert->notify(new CustomerRepliedNotification($ticket));
            }

            User::where('role', 'support_manager')
                ->get()
                ->each(function ($manager) use ($ticket) {
                    $manager->notify(new CustomerRepliedNotification($ticket));
                });
        }

        if (Auth::user()->isSupportManager()) {
            $ticket->user->notify(new SupportManagerRepliedNotification($ticket));
        }

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'پیام با موفقیت اضافه شد.');
    }
}
