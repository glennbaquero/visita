<?php

namespace App\Http\Controllers\API\Bookings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Notifications\Reservation\BookingNotification;

use App\Models\Guests\Guest;
use App\Models\Books\Book;
use App\Models\Emails\GeneratedEmail;

use DB;
use Carbon\Carbon;

class WalkinController extends Controller
{

	/**
     * adding a walkin reservation
     * @return string
     */
    public function reservation(Request $request) 
    {
    	DB::beginTransaction();
    		$main_contact_vars = $request->only(['main_contact_person']);
    		$main_contact_vars['main_contact_person']['main'] = true;
    		$guests_vars = $request->only(['guests']);

            $bookings_vars = $request->only(['booking_details']);
            $invoice_vars = $request->only(['invoice']);
    		$bookings_vars['booking_details']['destination_id'] = $request->user()->destination_id;
    		$bookings_vars['booking_details']['is_walkin'] = true;

            $book = $request->user()->books()->create($bookings_vars['booking_details']);
    		$main = $book->guests()->create($main_contact_vars['main_contact_person']);

    		foreach ($guests_vars['guests'] as $guests) {
    			$book->guests()->create([
                    'first_name' => $guests['first_name'],
                    'last_name' => $guests['last_name'],
                    'nationality' => $guests['nationality'],
                    'email' => $guests['email'],
                    'contact_number' => $guests['contact_number'],
                    'birthdate' => $guests['birthdate'],
                    'special_fee_id' => $guests['special_fee_id'],
                    'visitor_type_id' => $guests['visitor_type_id'],
                    'gender' => $guests['gender'],
                ]);
    		}

            $invoice = $request->user()->invoices()->create([
                'book_id' => $book->id,
                'conservation_fee' => $invoice_vars['invoice']['conservation_fee'],
                'platform_fee' => $invoice_vars['invoice']['platform_fee'],
                'sub_total' => $invoice_vars['invoice']['sub_total'],
                'grand_total' => $invoice_vars['invoice']['grand_total'],
                'reference_code' => $invoice_vars['invoice']['reference_code'],
                'is_paid' => true,
                'is_approved' => true,
            ]);

            $cms = GeneratedEmail::where('notification_type', 'Booking notification')->first();
            $main->notify(new BookingNotification($book, $cms));
    	DB::commit();
        $booking['id'] = $book->id;
        $booking['main_contact'] = $book->guests()->where('main', 1)->first();
        $booking['is_walkin'] = $book->is_walkin ? 'Walk-In' : 'Online';
        $booking['is_walkin_label'] = $book->is_walkin ? 'Walk-In' : 'Online';
        $booking['guests'] =  $book->guests;
        $booking['allocation'] = $book->allocation;
        $booking['schedule'] = Carbon::parse($book->scheduled_at)->format('j M Y');
        $booking['status'] = $book->getStatus();
        $booking['created_at'] = $book->created_at->format('j M Y h:i A');
        $booking['violations'] = $book->groupViolations;
        $booking['representative'] = $book->representative ?? null;
        $booking['group_violations'] = $book->groupViolations;
        $booking['group_remarks'] = $book->groupRemarks;
        $booking['ended_at'] = $book->ended_at;
        $booking['started_at'] = $book->started_at;
        $booking['time'] = $book->start_time;

    	return response()->json([
    		'success' => true,
            'book' => $booking
    	]);
    }


    /**
     * Add new guest to current selected book from app
     * @return string
     */
    public function addNewGuest(Request $request) 
    {
        $book = Book::find($request->book_id);
        $vars = $request->only(['guest']);
        DB::beginTransaction();
            $book->increment('total_guest');
            $book->save();
            $book->guests()->create($vars['guest']);
        DB::commit();

        return response()->json([
            'success' => true
        ]);
    } 
}
