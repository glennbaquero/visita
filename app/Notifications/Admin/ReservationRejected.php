<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Carbon\Carbon;

class ReservationRejected extends Notification
{
    use Queueable;

    public $notification;
    private $invoice;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notification, $invoice)
    {
        $this->notification = $notification;
        $this->invoice = $invoice;
        $this->message = str_replace('[timestamp]', Carbon::now()->format('M. d Y'), str_replace('[reason_for_reject]', $invoice->rejected_reason, $notification->message));
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
                ->greeting('Dear Guest,')
                ->line($this->message)
                ->line('<a href="'.route('web.dashboard').'">View Dashboard</a>');
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
            'message' => $this->message,
            'title' => $this->notification->title,
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
