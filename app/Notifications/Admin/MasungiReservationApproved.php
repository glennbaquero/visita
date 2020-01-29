<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MasungiReservationApproved extends Notification
{
    use Queueable;

    public $next_step;
    private $invoice;
    public $masungi_url = config('masungi.url');

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($next_step, $invoice)
    {
        $this->next_step = $next_step;
        $this->invoice = $invoice;
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
                ->subject(config('app.name') . ': ' . 'Reservation Approved!')
                ->greeting('Hello ' . $notifiable->renderName() . ',')
                ->line('Your reservation is approved!')
                ->line('To complete your reservation please click the link below to redirect you to payment.')
                ->line('Next step : '.$this->next_step)
                ->line('Invoice Reference # : '.$this->invoice->reference_code)
                ->line('Total Payment: '.$this->invoice->grand_total)
                ->line('Thank you!')
                ->action('Pay now', 'http://localhost:8000/payment/'.$notifiable->renderName().'/'.$this->invoice->reference_code.'/'.$this->invoice->grand_total);
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
            'message' => 'Your reservation is approved!',
            'title' => 'Reservation Approved!',
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
