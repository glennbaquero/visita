<?php

namespace App\Http\Controllers\API\Books;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Books\Book;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    /**
     * Fetch all bookings 
     */
    public function fetch(Request $request)
    {
        $items = Book::where('destination_id', $request->destination_id)->whereDate('scheduled_at', $request->selected_date)->get();

        $items = $items->map(function($item) {
            return [
                'id' => $item->id,
                'main_contact' => $item->guests()->where('main', 1)->first(),
                'is_walkin' => $item->is_walkin ? 'Walk-In' : 'Online',
                'guests' => $item->guests,
                'allocation' => $item->allocation,
                'schedule' => Carbon::parse($item->scheduled_at)->format('j M Y h:i A'),
                'time' => Carbon::parse($item->scheduled_at)->toTimeString(),
                'status' => $item->status ? 'Finished' : 'On-Queue',
                'created_at' => $item->created_at->format('j M Y h:i A'),
                'violations' => $item->groupViolations,
                'representative' => $item->representative ?? null,
                'remarks' => $item->groupRemarks,
            ];
        });

        return response()->json([
            'bookings' => $items,
        ]);
    }

    /**
     * Update Assigned Representative
     * 
     * @param Illuminate\Http\Request
     * @return json $response
     */
    public function updateRepresentative(Request $request)
    {
        Book::find($request->book_id)->update(['destination_representative_id' => $request->representative_id]);

        return response()->json(['message' => 'Success']);
    }
}
