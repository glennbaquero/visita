<?php

namespace App\Notifications\Web\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationReceived extends Notification
{
    use Queueable;

    private $invoice;
    private $body;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice, $body)
    {
        $this->invoice = $invoice;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject($this->body->title)
                ->greeting('Hello ' . $notifiable->renderName() . ',')
                ->line($this->body->message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Reservation for approval Reference # : '. $this->invoice->reference_code,
            'title' => $this->body->title,
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
