<?php

namespace App\Notifications\Masungi;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Carbon\Carbon;

class InitialPaymentPaid extends Notification
{
    use Queueable;

    private $invoice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
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
                    ->greeting('Dear '.$notifiable->first_name.',')
                    ->line('We have received the confirmation of your payment and have finalised the requested trail date and time for you ('.$this->invoice->book->scheduled_at->format('M d, Y').' ,'. Carbon::createFromFormat('H:i:s', $this->invoice->book->start_time)->format('h:i A') .') for '.$this->invoice->book->total_guest.' guest/s. For questions regarding your upcoming visit,you may reach us via guestcare@masungigeoreserve.com or using these numbers: 09951869911or 09088887002')
                    ->line('Kindly arrive 30 minutes ahead your scheduled trail visit, otherwise entry may be cut short, or forgone. Please understand that any tardiness will inevitably cause cascading delays on trail visits for the day.')
                    ->line('Here are just a few more reminders to take note before your visit! We will see you then!')
                    ->line('<b>SETTLE REMAINING BALANCE</b>')
                    ->line('<ul><li>In our aim to make our trail activities more seamless, we have removed cash transactions on site since August 2016. As such, kindly settle any remaining balance for existing or additional guests on (Date, 2020) or at least four (4) banking days before your date of visit. Please do send us a proof of payment to payments@masungigeoreserve.com for this by then. To settle via Paypal, please advise us so that we can send you a custom Paypal invoice.</li></ul>')
                    ->line('WHAT TO BRING')
                    ->line('<ul><li>Kindly bring only copy of proof/s of payment, extra clothes, and valuables inside the georeserve. We highly discourage bringing of large bags and unnecessary items inside that may make the trail less comfortable for you.</li></ul>')
                    ->line('<ul><li>Please bring your water jugs/tumblers - there are refilling stations the starting and end point of the trail. This is at the Silungan (briefing area) and Liwasan (final rest stop). Typically, guests would consume 1-2 litres of water.</li></ul>')
                    ->line('<ul><li>Meals are not allowed to be brought inside. For your comfort, please eat a sufficient meal prior to the trail. The georeserve can allow trail food such as peanuts, chocolate, trail mixes, and biscuits. Complimentary light snacks will be served near the end of the trail.</li></ul>')
                    ->line('<ul><li>As there may be a couple more roads to get to the reserve, we strongly recommend you to bring a private vehicle.</li></ul>')
                    ->line('WHAT TO WEAR')
                    ->line('<ul><li>Do wear comfortable hiking attire (long pants/leggings, loose shirts, non-slips & closed shoes suitable for a hike). Light jackets and long sleeves will be necessary for certain parts of the trail. For added comfort, you may also bring gloves.</li></ul>')
                    ->line('<ul><li>For safety purposes, slippers are not allowed to be used inside. Please wear appropriate closed shoes.</li></ul>')
                    ->line('<ul><li>There may be bouts of drizzles and rain from time to time. In anticipation, we recommend bringing extra clothes and raincoats. Ponchos, as a last resort option, may be provided.</li></ul>')
                    ->line('POLICIES')
                    ->line('<ul><li>Being a sanctuary for wildlife, please review the reserve\'s policies <b>(i.e. no bringing in of any smoking paraphernalia, no smoking, no littering and noise is prohibited, etc.)</b> and waiver/health form with the entire group, including drivers, and aides. Policies apply to the whole georeserve, including the trail, the provided parking spaces, and the road/roadside fronting the gate. By entering the georeserve, your party agrees to these policies and waivers.</li></ul>')
                    ->line('<ul><li>Please note that a penalty of <b>PHP 3,000.00</b> automatically applies for the first non-compliance to littering, smoking, and picking/collection of animals, plants, and rocks policies.</li></ul>')
                    ->line('<ul><li>mit personal tipping among park rangers. This ensures non-interference of visits to priority conservation work, and encourages consistency in experience among guests. These are critical from a holistic perspective. Should there be an absolutely inevitable need to tip, there is a communal bucket located in Silungan and Liwasan. This ensures equitable distribution among rangers doing guiding, maintenance, and protection works.</li></ul>')
                    ->line('OTHERS')
                    ->line('<ul><li>Guest restrooms are located in Silungan (briefing area). This is a quick 5-minute walk from the parking drop-off area.</li></ul>')
                    ->line('<ul><li>Expect the trail to slow down at two particular stops - Sapot and Duyan. There are time allotments for these stops to observe. Kindly listen to your park rangers and observe their instructions so as to maximise your time and visit.</li></ul>')
                    ->line('<ul><li>While trail visits are a rain or shine activity, cancellations due to extreme weather conditions may be made to ensure safety. Similarly, paths or stops may be diverted for critical concerns.</li></ul>')
                    ->line('HOW TO GET THERE')
                    ->line('<b>Via Private Transport</b>')
                    ->line('<p>Route 1 via Marcos Highway (RECOMMENDED)</p>
                        <p>Cruise through Marcos Highway. You will pass through Masinag, Cogeo, Boso-Boso Resort, Foremost Farms, and Palo Alto. Slow down at Garden Cottages along Marcos</p>
                        <p>Highway. The entrance to Masungi, signalled by its logo, will be on your right.</p>
                        <p>Route 2 Via Sampaloc in Tanay, from the Manila East Road</p>
                        <p>Take Sampaloc Road. You will pass by the street to Daranak Falls. Go straight until you arrived a junction. Turn left. Follow this scenic road. It\'ll be a 45 minutes to an hour ride. You will pass by Sierra Madre resort on your right, and Ten Cents to Heaven. Kilometer 47 Masungi entrance, signalled by its logo, will be on your left when taking this route.</p>')
                    ->line('<b>Via Public Transportation<b> (JEEPS ARE ONLY AVAILABLE UNTIL 6:30 PM)')
                    ->line('<p>Route 1 Via Cogeo</p>
                            <p>Ride a van or jeepney going to Padilla/Cogeo Gate 2. Get off at Gate 2 and from there, take a jeepney bound to Sampaloc via Marcos Highway in Tanay. It\'ll be the same route as Route 1 in private transportation.</p>
                            <p>Route 2 Via Tanay</p>
                            <p>Take a jeepney to Tanay town proper. Hire a tricycle to take you to Garden Cottages. Fare is P500 one way but can be haggled down to P350. Alternatively, you can hire up to the Sampaloc junction. There are jeepneys going to Antipolo/Cogeo that will pass by Kilometer 47 Masungi entrance.</p>
                            <p>**Things to account for: Jeeps and vehicles in general, are difficult to find once you get to Garden Cottages. You can spend up to an hour waiting for a jeepney. Added to this, jeeps are often filled to the roof when they pass by the area.**</p>
                            <p>**For guests coming from Metro Manila, kindly stay on Marcos Highway/ Marikina-Infanta Road up to Kilometer 47 (do not use the Manila East Road or Baras-Pinugay Road) to avoid getting lost or taking a significantly longer route.**</p>
                            <p>**While the location is on Waze, please note that it only gives the approximate location of the entrance (+/- 3 km, from observation). Kindly refer to the materials herewith for your peace of mind. Should you have companions taking a different vehicle, kindly share this with them as well.**</p>
                            <p>We strongly suggest that you familiarise yourself with the location of Kilometer 47 via Google maps and print our the location map below ahead of time. Signal is often very weak or non-existent in the area. Please take note that there are no grand entrances or signages. The entrance to the georeserve is signalled by a simple logo marker by the highway.</p>')
                    ->line('Masungi Georeserve Location Map: Use Marcos Highway route coming from Metro Manila. <a href="https://www.google.com.ph/maps/place/Masungi+Georeserve/@14.6048064,121.3150886,1789m/data=!3m1!1e3!4m5!3m4!1s0x33979457fe4d85ab:0xf0304d8f00c74db9!8m2!3d14.6021942!4d121.319657">CLICK FOR GOOGLE MAPS</a>')
                    ->line('<b>Masungi Georeserve Entrance Signage:</b> At the right side of the road. For early morning guests, please note that the gates open at 5:00 am to 5:30 am.')
                    ->line('Thank you and we look forward to seeing you around soon! Safe travels to the georeserve!')
                    ->line('<p>Best regards,</p>
                            <p>Masungi Georeserve (Garden Cottages)</p>
                            <p>Kilometer 45, Marcos Highway,</p>
                            <p>Baras, Rizal, Philippines, 1970</p>
                            <p>Website: <a href="masungi-uat.praxxys.ph">www.masungigeoreserve.com</a></p>')
                    ->line('</i>*This is a no-reply email. For questions regarding your visit please email guestcare@masungigeoreserve.com. For payments, please email payments@masungigeoreserve.com</i>');
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
