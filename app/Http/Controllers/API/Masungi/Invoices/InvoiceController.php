<?php

namespace App\Http\Controllers\API\Masungi\Invoices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\API\Masungi\InvoiceStoreRequest;

use Illuminate\Validation\ValidationException;

use App\Models\Users\Management;
use App\Models\Invoices\Invoice;
use App\Models\Books\Book;
use App\Models\Allocations\Allocation;
use App\Models\Destinations\Destination;
use App\Models\Users\Admin;
use App\Models\Capacities\Capacity;
use App\Models\Emails\GeneratedEmail;

use App\Notifications\Reservation\BookingNotification;
use App\Notifications\Web\Bookings\NewBookingNotification;
use App\Notifications\Admin\Paypal\AdminInvoicePaid;
use App\Notifications\Web\Paypal\UserInvoicePaid;

use DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
	private $masungi_user_id;

	public function validateRequest($request) {
		if(!$request->trail_name || !$request->start_time || !$request->scheduled_at || 
    		!$request->total_guest || !$request->trail_data || !$request->guests || 
    		!$request->conservation_fee || $request->transaction_fee === null ||
    		!$request->sub_total || !$request->grand_total || !$request->is_paypal_payment) {

			return 2; // ID of masungi user is required 
		}
		return true;
	}

    public function store(Request $request, $user) 
    {

    	// $validation = $this->validateRequest($request);

    	// if($validation === 2) {
    	// 	return $validation;
    	// }

    	DB::beginTransaction();

    		$allocation = Allocation::where('name', $request->trail_name)->first();
    		$destination = Destination::where('name', 'Masungi Georeserve')->first();

    		// if(!$request->user_id) {
    		// 	return 1; // ID of masungi user is required 
    		// }

    		if(!$destination) {
    			return 10; // 'destination' => "Masungi is not registered in system, contact Visita then add the Masungi in their system (Required to add name = Masungi)",
    		}

    		if(!$allocation) {
    			
    			return 11; // 'trail' => "Trail is not registered in system, contact Visita and add the trail in under Masungi Destination"
    		}

    		$book = $user->books()->create([
    			'allocation_id' => $allocation->id,
    			'destination_id' => $destination->id,
	    		'start_time' => $request->start_time,
	    		'scheduled_at' => $request->scheduled_at,
	    		'total_guest' => $request->total_guest,
                'is_walkin' => false,
                'from_masungi_reservation' => true,
                'trail_data' => json_encode($request->trail_data),
                'other_data' => $request->other_data ? json_encode($request->other_data) : null,
                // 'masungi_user_id' => $request->user_id,
    		]);
    		foreach ($request->guests as $key => $guest) {
                $book->guests()->create([
	    			'main' => $guest['main'] == '1' ? 1 : 0,
	    			'first_name' => $guest['first_name'],
	    			'last_name' => $guest['last_name'],
                    // 'gender' => $guest['gender'],
	    			'gender' => 'Male',
	    			'nationality' => $guest['country'],
	    			'emergency_contact_number' => $guest['contact_number'],
	    			'contact_number' => $guest['contact_number'],
	    			'email' => $guest['email'],
	    			'birthdate' => $guest['birthday'],
	    		]);
	    	}

	    	$user->invoices()->create([
	    		'book_id' => $book->id,
	    		'conservation_fee' => $request->conservation_fee,
	    		'platform_fee' => 0,
	    		'transaction_fee' => $request->transaction_fee,
	    		'sub_total' => $request->sub_total,
	    		'grand_total' => $request->grand_total,
	    		'is_paypal_payment' => $request->is_paypal_payment,
	    		'reference_code' => $request->grand_total.$this->generateReferenceCode().'MSNG',
                'is_fullpayment' => $request->is_fullpayment,
                'amount_settled' => $request->amount_settled,
                'balance' => $request->balance,
	    	]);


	    	$main = $book->guests->where('main', 1)->first();
            $qr_email = GeneratedEmail::where('notification_type', 'Booking notification')->first();
            $new_booking_frontliner = GeneratedEmail::where('notification_type', 'New booking notification')->first();
	    	$main->notify(new BookingNotification($book, $qr_email));
      //       $admins = Admin::all();
	    	// foreach ($admins as $admin) {
	     //        $admin->notify(new NewBookingNotification($book->destination, $book->allocation, $book, $main, $new_booking_frontliner));
	     //    }
    	DB::commit();


    	return 200;
    }

    public function generateReferenceCode() 
    {
    	$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
	    return substr(str_shuffle($str_result),  
	                       0, 20);
    }

    // public function showReservations($masungi_user_id, $user)
    public function showReservations($user)
    {
    	// $this->masungi_user_id = $masungi_user_id;
    	$result = [];
    	$invoices = $user->invoices()->whereHas('book', function($book) {
    		$book->where('masungi_user_id', $this->masungi_user_id);
    	})->get();
        $invoices = [];

    	foreach ($invoices as $invoice) {
    		array_push($result, [
    			'trail' => $invoice->book->allocation->name,
    			'scheduled_at' => $invoice->book->scheduled_at->format('m/d/Y'),
    			'total_guest' => $invoice->book->total_guest,
    			'status_label' => $invoice->renderStatusLabel(),
    			'grand_total' => $invoice->grand_total,
    			'sub_total' => $invoice->sub_total,
    			'conservation_fee' => $invoice->conservation_fee,
    			'transaction_fee' => $invoice->transaction_fee,
    			'is_paid' => $invoice->is_paid ? true : false,
    			'is_approved' => $invoice->is_approved ? true : false,
    			'is_paypal_payment' => $invoice->is_paypal_payment ? true : false,
    			'reference_code' => $invoice->reference_code,
    			'id' => $invoice->id,
    			'showImgTag' => $invoice->bank_deposit_slip ?? false,
    			'deposit_slip' => !$invoice->is_paypal_payment ? url('storage/'.$invoice->bank_deposit_slip) : null,
    			'guests' => $invoice->book->getGuests(),
    			'trail_data' => json_decode($invoice->book->trail_data),
    			'other_data' => json_decode($invoice->book->other_data),
    		]);
    	}

    	return response()->json([
    		'items' => $result
    	]);
    }

    public function paypalPaid($request) 
    {

        Log::info($request);
        Log::info($request['reference_code']. '----'.$request['payment_code']);

    	if(!$request['reference_code']) {
    		return 3; // reference code is required 
    	}
        Log::info('Condition pass');

        $invoice = Invoice::where('reference_code', $request['reference_code'])->first();      
        Log::info('Invoice is get');
		
		$admins = Admin::all();
        Log::info('Admins get');
		$main = $invoice->book->guests->where('main', true)->first();
        Log::info('main guest get');
		
    	DB::beginTransaction();
            Log::info($invoice);
            $invoice->update([
                'payment_code' => $request['payment_code'],
            ]);     

            if($invoice->is_fullpayment) {
                $invoice->paid = true;
                $invoice->is_firstpayment_paid = true;
                $invoice->is_secondpayment_paid = true;
                $main->notify(new UserInvoicePaid($invoice));
                Log::info('Email sent to user');
                foreach ($admins as $admin) {
                   $admin->notify(new AdminInvoicePaid($invoice));
                }
                Log::info('Email sent to admin');
            }

            if(!$invoice->is_fullpayment && !$invoice->is_firstpayment_paid) {
                $invoice->is_firstpayment_paid = true;
            } 

            if(!$invoice->is_fullpayment && $invoice->is_firstpayment_paid && !$invoice->is_secondpayment_paid) {
                $invoice->is_secondpayment_paid = true;
                $invoice->paid = true;
                $main->notify(new UserInvoicePaid($invoice));
                Log::info('Email sent to user');
                foreach ($admins as $admin) {
                   $admin->notify(new AdminInvoicePaid($invoice));
                }
                Log::info('Email sent to admin');
            }

            $invoice->save();
            // $invoice->is_paid = true;
            // $invoice->payment_code = $request['payment_code'];
            // $invoice->save();
            Log::info('invoice update');

    		
    	DB::commit();
        Log::info('DB commit');
        


    	return 200;
    }

    public function getAvailability($request) {
        $allocation = Allocation::where('name', $request->trail_name)->first();
        $capacity = Capacity::where('allocation_id', $allocation->id)->first()->online;
        $time = $request->start_time;
        $schedule_date = $request->date;

        $invoices = Invoice::where('is_paid', true)->get();

        $count = 0;

        $canShow = 'true';
        $sample = [];
        foreach ($invoices as $key => $invoice) {
            if($invoice->book->allocation->id === $allocation->id && $invoice->book->scheduled_at == Carbon::parse($schedule_date) && $invoice->book->start_time == Carbon::parse($time)->format('H:i:s')) {
                $count += 1;
            }
            // array_push($sample, [
            //     'invoice' => $invoice->book
            // ]);
            // $count += $invoice->book->where('allocation_id', $allocation->id)->count();

        }

        if($capacity <= $count) {
            $canShow = 'false';
        }

        return $canShow;
    }
}
