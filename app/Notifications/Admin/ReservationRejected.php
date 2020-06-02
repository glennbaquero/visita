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
        $guest = $invoice->book->guests()->where('main', true)->first()->first_name;
        $this->message = str_replace('[date of visit]', Carbon::now()->format('M. d Y'), str_replace('[insert reason for rejection here]', $invoice->rejected_reason, $notification->message));
        $this->message = str_replace('[Destination]', $invoice->book->destination->name, str_replace('[First Name]', $guest, $this->message));
        $this->message = str_replace('[number of guests]', $invoice->book->total_guest, $this->message);
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
