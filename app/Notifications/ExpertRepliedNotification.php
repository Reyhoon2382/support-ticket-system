<?php

namespace App\Notifications;

use App\Models\Ticket;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\Notification;

class ExpertRepliedNotification extends Notification implements ShouldQueue

{

    use Queueable;

    public function __construct(public Ticket $ticket)

    {

        //

    }

    public function via(object $notifiable): array

    {

        return ['mail', 'database'];

    }

    public function toMail(object $notifiable): MailMessage

    {

        return (new MailMessage)

            ->subject('پاسخ جدید به تیکت شما')

            ->line('یک متخصص به تیکت شما پاسخ داده است.')

            ->line('شماره تیکت: ' . $this->ticket->ticket_number)

            ->line('عنوان: ' . $this->ticket->title)

            ->action('مشاهده تیکت', url('/tickets/' . $this->ticket->id));

    }

    public function toArray(object $notifiable): array

    {

        return [

            'ticket_id' => $this->ticket->id,

            'title' => $this->ticket->title,

            'status' => $this->ticket->status->value,

            'message' => 'یک متخصص به تیکت شما پاسخ داده است.',

        ];

    }

}