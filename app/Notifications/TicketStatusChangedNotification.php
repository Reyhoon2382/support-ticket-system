<?php

namespace App\Notifications;

use App\Models\Ticket;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Notification;

class TicketStatusChangedNotification extends Notification implements ShouldQueue

{

    use Queueable;

    /**
     * Create a new notification instance.
     */

    public function __construct(public Ticket $ticket, public string $oldStatus)

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

            ->subject('وضعیت تیکت به‌روزرسانی شد')

            ->line('وضعیت تیکت شما به‌روزرسانی شده است.')

            ->line('شماره تیکت: ' . $this->ticket->ticket_number)

            ->line('عنوان: ' . $this->ticket->title)

            ->line('وضعیت قبلی: ' . $this->oldStatus)

            ->line('وضعیت جدید: ' . $this->ticket->status->value)

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

            'old_status' => $this->oldStatus,

            'message' => 'وضعیت تیکت شما به‌روزرسانی شده است.',

        ];

    }

}