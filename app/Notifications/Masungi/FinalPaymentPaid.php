<?php

namespace App\Notifications\Masungi;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FinalPaymentPaid extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
                    ->greeting('Dear '.$notifiable->first_name.',')
                    ->line('We are pleased to confirm that we have received your full payment for your visit.')
                    ->line('Again, for any concerns for your upcoming visit, Masungi Georeserve may also be reached via email through guestcare@masungigeoreserve.com, or through the following numbers: 09951869911 and 09088887002.')
                    ->line('Numbers are reachable from Mondays to Fridays, 8:00AM to 5:00PM. Should calls have difficulty coming through for urgent concerns, kindly leave us with a text message.')
                    ->line('We will see you soon!')
                    ->line('<p>Best regards,</p>
                            <p>Masungi Georeserve (Garden Cottages)</p>
                            <p>Kilometer 45, Marcos Highway,</p>
                            <p>Baras, Rizal, Philippines, 1970</p>
                            <p>Website: www.masungigeoreserve.com</p>')
                    ->line('*This is a no-reply email. For questions regarding your visit please email guestcare@masungigeoreserve.com. For payments, please email payments@masungigeoreserve.com');
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
            //
        ];
    }
}
