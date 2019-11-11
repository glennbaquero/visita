<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserInquiry extends Notification
{
    use Queueable;

    protected $item;
    protected $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;
        $this->title = "Customer Inquiry";
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
                    ->greeting('Hello ' . $notifiable->renderName() . ',')
                    ->line('Visitor ' . $this->item->fullname . ' has sent an inquiry')
                    ->line('Contact Number: ' . $this->item->contact_number)
                    ->line('Email: ' . $this->item->email)
                    ->line('Message: ' . $this->item->message)
                    ->action('Check Inquiry', $this->item->renderShowUrl('admin'))
                    ->line('Thank you for using our application!');
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
            'title' => $this->title,
            'subject_id' => $this->item->id,
            'subject_type' => get_class($this->item),
        ];
    }
}
