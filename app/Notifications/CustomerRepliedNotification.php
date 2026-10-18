<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerRepliedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Ticket $ticket)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('پاسخ جدید به تیکت')
            ->line('یک مشتری به این تیکت پاسخ داده است.')
            ->line('شماره تیکت: ' . $this->ticket->ticket_number)
            ->line('عنوان: ' . $this->ticket->title)
            ->action('مشاهده تیکت', url('/tickets/' . $this->ticket->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => $this->ticket->title,
            'status' => $this->ticket->status->value,
            'message' => 'یک مشتری به این تیکت پاسخ داده است.',
        ];
    }
}