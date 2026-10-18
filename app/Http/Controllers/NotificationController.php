<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    public function markAsRead(string $notification): RedirectResponse
    {
        $notification = auth()->user()->notifications()->where('id', $notification)->firstOrFail();

        $notification->markAsRead();

        return redirect()->route('tickets.show', $notification->data['ticket_id']);
    }

    public function markAllAsRead(): RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back();
    }
}
