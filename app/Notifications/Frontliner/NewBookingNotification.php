<?php

namespace App\Notifications\Frontliner;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Carbon\Carbon;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $title;
    public $request;
    public $description;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
        $this->title = 'New Reservation';
        $this->description = 'A new reservation of visitor for '.Carbon::parse($request['scheduled_at'])->format('M d, Y'). '.';
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
            ->subject(config('app.name') . ': ' . $this->title)
            ->greeting('Hello ' . $notifiable->fullname . ',')
            ->line($this->description)
            ->line('Details of point person of the group ')
            ->line('Mr/Mrs/Ms.'. $this->request->first_name. ' '. $this->request->last_name)
            ->line('Email : '. $this->request->email)
            ->line('Contact Number : '. $this->request->contact_number)
            ->line('Point person of the group details : ')
            ->line('For full details check the calendar in Visita Mobile App.');
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
            'message' => $this->description,
            'title' => $this->title,
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
