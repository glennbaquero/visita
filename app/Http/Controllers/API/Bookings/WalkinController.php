<?php

namespace App\Http\Controllers\API\Bookings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Guests\Guest;
use App\Models\Books\Book;

use DB;

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
    		$bookings_vars['booking_details']['destination_id'] = $request->user()->destination_id;
    		$bookings_vars['booking_details']['is_walkin'] = true;

    		Guest::create($main_contact_vars['main_contact_person']);

    		foreach ($guests_vars['guests'] as $guests) {
    			Guest::create($guests);
    		}
    		Book::create($bookings_vars['booking_details']);
    	DB::commit();

    	return response()->json([
    		'success' => true
    	]);
    }
}
