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

            $book = Book::create($bookings_vars['booking_details']);
    		$book->guests()->create($main_contact_vars['main_contact_person']);

    		foreach ($guests_vars['guests'] as $guests) {
    			$book->guests()->create($guests);
    		}
    	DB::commit();

    	return response()->json([
    		'success' => true
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
            $book->guests()->create($vars['guest']);
        DB::commit();

        return response()->json([
            'success' => true
        ]);
    } 
}
