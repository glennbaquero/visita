<?php

namespace App\Http\Controllers\Admin\Calendars;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Books\Book;
use App\Models\Destinations\Destination;
use Carbon\Carbon;

class CalendarController extends Controller
{

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Calendars\CalendarMiddleware', 
            ['only' => ['index', 'getBookings']]
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = auth()->guard('admin')->user();
        $destinations = Destination::with('allocations')->get();
        if($admin->destination_id) {
            $destinations = Destination::where('id', $admin->destination_id)->with('allocations')->get();
        }

        return view('admin.calendar.index', [
            'destinations' => $destinations
        ]);
    }

    /**
     * Show the bookings for selected day
     *
     * @return \Illuminate\Http\Response
     */
    
    public function getBookings(Request $request) 
    {
        $selectedDate = Carbon::parse($request->selectedDate)->toDateString();
        $bookings = Book::where('scheduled_at', $selectedDate)->get();

        return response()->json([
            'selectedDate' => $selectedDate,
            'bookings' => $bookings,
            'showBookingsUrl' => route('admin.bookings.index')
        ]);
    }
}
