<?php

namespace App\Http\Controllers\Web\Invoices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\Notifications\Reservation\BookingNotification;
use App\Notifications\Web\Bookings\NewBookingNotification;
use App\Notifications\Reservation\BankDepositSlipUploadedNotification;
use App\Notifications\Web\Reservation\ReservationReceived;
use Illuminate\Validation\ValidationException;

use App\Models\Invoices\Invoice;
use App\Models\Books\Book;
use App\Models\Users\Admin;
use App\Models\Emails\GeneratedEmail;
use App\Models\Destinations\Destination;
use App\Models\Allocations\Allocation;
use App\Models\Agencies\Agency;

use App\Ecommerce\PaynamicsProcessor;

use DB;
use Carbon\Carbon;
use Storage;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
    	$guests = json_decode($request->guests);
        $admins = Admin::all();
        $email = GeneratedEmail::where('notification_type', 'Reservation Received')->first();

        $totalReserved = Book::where('destination_id', $request->destination_id)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->count();
        $totalReservation = Destination::find($request->destination_id)->capacity_per_day;
        $availableSeat = $totalReservation - $totalReserved;

    	DB::beginTransaction();

	    	$book = auth()->user()->books()->create([
	    		'start_time' => $request->start_time,
	    		'allocation_id' => $request->allocation_id,
	    		'destination_id' => $request->destination_id,
	    		'scheduled_at' => $request->scheduled_at,
	    		'total_guest' => $request->total_guest,
	    		'agency_code' => $request->agency_code,
                'is_walkin' => false
	    	]);

	    	foreach ($guests as $key => $guest) {
                $upload_path = null;

                if($request['special_fee_path'][$key] != null || $request['special_fee_path'][$key] != '') {
                    $file = $request['special_fee_path'][$key];
                    $filename = $file->getClientOriginalName();
                    $path = 'public/special_fee';
                    $upload_path = Storage::putFileAs($path, $file, $filename);
                }

	    		$book->guests()->create([
	    			'visitor_type_id' => $guest->visitor_type_id,
	    			'special_fee_id' => $guest->special_fee_id != 0 ? $guest->special_fee_id : null,
	    			'main' => $guest->main,
	    			'first_name' => $guest->first_name,
	    			'last_name' => $guest->last_name,
	    			'nationality' => $guest->nationality,
	    			'gender' => $guest->gender,
	    			'emergency_contact_number' => $guest->emergency_contact_number,
	    			'contact_number' => $guest->contact_number,
	    			'email' => $guest->email,
	    			'birthdate' => $guest->birthdate,
                    'special_fee_path' => $upload_path
	    		]);
	    	}

	    	$invoice = auth()->user()->invoices()->create([
                // 'user_id' => auth()->user()->id,
	    		'book_id' => $book->id,
	    		'conservation_fee' => $request->conservation_fee,
	    		'platform_fee' => $request->platform_fee,
	    		'transaction_fee' => $request->transaction_fee,
	    		'sub_total' => $request->sub_total,
	    		'grand_total' => $request->grand_total,
	    		'is_paypal_payment' => $request->is_paypal_payment,
	    		'reference_code' => $request->grand_total.$this->generateReferenceCode().'VST'
	    	]);


    	DB::commit();

        $invoice->bookable->notify(new ReservationReceived($invoice, $email));

    	return response()->json([
    		'success' => true
    	]);
    }

    public function generateReferenceCode() 
    {
    	$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
	    return substr(str_shuffle($str_result),  
	                       0, 20);
    }

    public function show(Request $request) 
    {
    	$result = [];
        if($request->sort === 'date') {
        	$invoices = auth()->user()->invoices()->orderBy('created_at', 'desc')->get();
        } elseif ($request->sort === 'paid') {
            $invoices = auth()->user()->invoices()->where(['is_paid' => true, 'is_approved' => true])->get();
        } elseif ($request->sort === 'pending') {
            $invoices = auth()->user()->invoices()->where(['is_paid' => false, 'is_approved' => true])->get();
        } elseif ($request->sort === 'for approval') {
            $invoices = auth()->user()->invoices()->where(['is_paid' => false, 'is_approved' => false])->whereNull('deleted_at')->get();
        } elseif($request->sort === 'rejected') {
            $invoices = auth()->user()->invoices()->whereNotNull('deleted_at')->get();
        }

    	foreach ($invoices as $invoice) {
    		array_push($result, [
    			'destination' => $invoice->book->destination->name,
    			'scheduled_at' => $invoice->book->scheduled_at->format('m/d/Y'),
    			'total_guest' => $invoice->book->total_guest,
    			'status_label' => $invoice->renderStatusLabel(),
    			'status_class' => $invoice->renderStatusClass(),
                'total' => $invoice->grand_total,
                'transaction_fee' => $invoice->transaction_fee,
    			'grand_total' => $invoice->transaction_fee + $invoice->grand_total,
    			'is_paid' => $invoice->is_paid ? true : false,
    			'is_approved' => $invoice->is_approved ? true : false,
    			'is_paypal_payment' => $invoice->is_paypal_payment ? true : false,
    			'reference_code' => $invoice->reference_code,
    			'id' => $invoice->id,
    			'showImgTag' => $invoice->bank_deposit_slip ?? false,
    			'deposit_slip' => !$invoice->is_paypal_payment ? url('storage/'.$invoice->bank_deposit_slip) : null,
                'deleted_at' => $invoice->deleted_at
    		]);
    	}

    	return response()->json([
    		'items' => $result
    	]);
    }

    public function uploadDepositSlip(Request $request)
    {
    	$request->validate([
            'bank_deposit_slip' => 'required|mimes:jpeg,bmp,png'
        ]);
		$invoice = Invoice::find($request->id);
        $admins = Admin::all();
        $main = $invoice->book->guests->where('main', true)->first();

    	DB::beginTransaction();
    		$image = $request->file('bank_deposit_slip')->store('deposit-slip', 'public');
    		$invoice->update([
    			'bank_deposit_slip' => $image
    		]);


            // foreach ($admins as $admin) {
            //    $admin->notify(new BankDepositSlipUploadedNotification($invoice, $main));
            // }
    	DB::commit();


    	return response()->json([
    		'message' => 200
    	]);
    }

    /**
    * Generate Paynamics form
    *
    * @param object $invoice
    * @return string $form
    */
    public function generatePaynamicsForm(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $paynamics = new PaynamicsProcessor();
        $signature = $paynamics->createXML($invoice);

        return response()->json([
            'signature' => $signature,
            'gateway_url' => config('ecommerce.paynamics.gateway')
        ]);
    }

    /**
     * Processing paynamics
     * 
     * @param  Requests $request 
     */
    public function processPaynamics(Request $request)
    {
        Log::info($request);
        $processor = new PaynamicsProcessor();

        /** Process Paynamics */
        return $processor->process($request);
    }

    /**
     * Paynamics success return
     * 
     */
    public function paynamicsReturn(Request $request)
    {
        $processor = new PaynamicsProcessor();
        $route = $processor->processReturnResponse($request);

        return redirect()->route('web.dashboard');
    }

    /**
     * Paynamics cancel
     * 
     */
    public function paynamicsCancel()
    {
         return redirect()->route('web.dashboard');
    }

    public function getRemaining(Request $request)
    {
        $destination = Destination::find($request->destination);
        $totalReservation = $destination->capacity_per_day;
        $experience = Allocation::find($request->allocation);
        $online_capacity = Allocation::find($request->allocation)->capacities->first()->online;
        if($online_capacity > $experience->destination->capacity_per_day) {
            $online_capacity = $experience->destination->capacity_per_day;
        }

        $totalReserved = Book::whereDate('scheduled_at', $request->date)->where('allocation_id', $request->allocation)->sum('total_guest');

        $availableSeat = $online_capacity - $totalReserved;

        if($availableSeat < 0) {
            $availableSeat = 0;
        }

        return response()->json([
            'online' => $online_capacity,
            'availableSeat' => $availableSeat
        ]);

    }

    public function agencyCodeChecker(Request $request) {
        $agency = Agency::where('name', $request->code)->first();

        if(!$agency) {
            throw ValidationException::withMessages([
                'message' => 'Agency code is not found.',
            ]);
        }


        $destination = Destination::find($request->destination);
        $totalReservation = $destination->capacity_per_day;
        $allocation = Allocation::find($request->allocation)->capacities->first()->agency;

        $totalReserved = Book::whereDate('scheduled_at', $request->date)->where('allocation_id', $request->allocation)->where('agency_code', '!=', 'null' )->sum('total_guest');

        $remaining = $allocation - $totalReserved;

        return response()->json([
            'agency' => $agency,
            'remaining' => $remaining
        ]);
    }
}
