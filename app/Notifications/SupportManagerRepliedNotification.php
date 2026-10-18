<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportManagerRepliedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Ticket $ticket)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('پاسخ جدید به تیکت شما')
            ->line('مدیر پشتیبانی به تیکت شما پاسخ داده است.')
            ->line('شماره تیکت: ' . $this->ticket->ticket_number)
            ->line('عنوان: ' . $this->ticket->title)
            ->action('مشاهده تیکت', route('tickets.show', $this->ticket->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'message' => 'مدیر پشتیبانی به تیکت شما پاسخ داده است.',
        ];
    }
}