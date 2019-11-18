<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Books\Book;
use Carbon\Carbon;

class ResourceFetchController extends Controller
{
    public function fetch(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Get the data of the dashboard of specific destination based on today's date
     */
    public function dashboard(Request $request)
    {
    	$today = Carbon::now();
    	// get current user login
    	$user = $request->user();

    	// get all booking based on current destination assigned for logged-in user
    	$bookings = Book::where('destination_id', $user->destination->id)->whereDate('scheduled_at', $today);
    	
    	// total of guest today
    	$total['guest'] = $bookings->get()->sum('total_guest');

    	// total of groups today
    	$total['groups'] = $bookings->get()->count();
    	
    	// get total checked in for walk in guest
    	$checked_in_walkin['visitors'] = $bookings->where('is_walkin', true)->whereDate('checked_in_at', $today)->get()->count(); 
    	$checked_in_walkin['groups'] = $bookings->where('is_walkin', true)->whereDate('checked_in_at', $today)->get()->count(); 

    	// get total checked in for online in guest
        $total_checked_in['online_visitor'] = $bookings->where('is_walkin', false)->whereDate('checked_in_at', $today)->get()->count(); 
        $total_checked_in['online_group'] = $bookings->where('is_walkin', false)->where('is_walkin', false)->whereDate('checked_in_at', $today)->get()->count(); 
        $total_checked_in['walk_in'] = $bookings->where('is_walkin', true)->whereDate('checked_in_at', $today)->get()->count(); 
    	$total_checked_in['walk_in_group'] = $bookings->where('is_walkin', true)->where('is_walkin', false)->whereDate('checked_in_at', $today)->get()->count(); 

    	// get the remaining capacity left for today 
    	$capacity_per_day = $user->destination->capacity_per_day;
    	$remaining = $capacity_per_day - $total['guest'];
    	$percentage = ($remaining / $capacity_per_day) * 100 - 100;

    	return response()->json([
    		'total' => $total,
    		'percentage' => round($percentage),
    		'remaining' => $remaining,
    		'total_checked_in' => $total_checked_in
    	]);
    }
}
