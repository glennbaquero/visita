<?php

namespace App\Http\Controllers\API\Books;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Books\Book;
use App\Models\Destinations\Destination;
use App\Models\Allocations\Allocation;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /**
     * Fetch all bookings 
     */
    public function fetch(Request $request)
    {
        $data = [];
        $time = Carbon::now()->format('h:i:s');
        $selected_date = Carbon::parse($request->selected_date.' '.$time);

        $items = Book::where('destination_id', $request->destination_id)->whereDate('scheduled_at', $request->selected_date)->get();

        if($request->filled('started_at')) {
            $items = Book::where('destination_id', auth()->guard('api')->user()->destination_id)->whereNotNull('started_at')->whereNull('ended_at')->get();
        }


        foreach ($items as $item) {
            if($item->invoice->is_paid == 1) {
                array_push($data, [
                   'id' => $item->id,
                   'main_contact' => $item->guests()->where('main', 1)->first(),
                   'is_walkin' => $item->is_walkin ? 'Walk-In' : 'Online',
                   'is_walkin_label' => $item->is_walkin ? 'Walk-In' : 'Online',
                   'guests' => $item->guests,
                   'allocation' => $item->allocation,
                   'schedule' => Carbon::parse($item->scheduled_at)->format('j M Y'),
                   // 'time' => Carbon::parse($item->scheduled_at)->toTimeString(),
                   'status' => $item->getStatus(),
                   'created_at' => $item->created_at->format('j M Y h:i A'),
                   'violations' => $item->groupViolations,
                   'representative' => $item->representative ?? null,
                   'group_violations' => $item->groupViolations,
                   'group_remarks' => $item->groupRemarks,
                   'ended_at' => $item->ended_at,
                   'started_at' => $item->started_at,
                   'time' => $item->start_time
                ]);
            }
        }

        // $items = $items->map(function($item) {
        //     return [
        //     ];
        // });

        return response()->json([
            'bookings' => $data,
        ]);
    }

    public function scan(Request $request) 
    {
        if (!$request->qr_id) {
            throw ValidationException::withMessages([
                'qr_id' => ['Please enter a QR ID']
            ]);
        }
        $qr = preg_replace('/\"/', '', $request->qr_id);
        $book = Book::where('qr_id', $qr)->first();

        if (!$book) {
            throw ValidationException::withMessages([
                'qr_id' => ['Reservation does not exist']
            ]);
        }
        $item['id'] = $book->id;
        $item['main_contact'] = $book->guests()->where('main', 1)->first();
        $item['is_walkin'] = $book->is_walkin ? 'Walk-In' : 'Online';
        $item['guests'] = $book->guests;
        $item['allocation'] = $book->allocation;
        $item['schedule'] = Carbon::parse($book->scheduled_at)->format('j M Y');
        // $item['time'] = Carbon::parse($book->scheduled_at)->toTimeString();
        $item['status'] = $book->status ? 'Finished' : 'On-Queue';
        $item['created_at'] = $book->created_at->format('j M Y h:i A');
        $item['violations'] = $book->groupViolations;
        $item['remarks'] = $book->groupRemarks;
        $item['ended_at'] = $book->ended_at;
        $item['start_at'] = $book->started_at;
        $item['time'] = $book->start_time;

        return response()->json([
            'booking' => $item
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

    public function remainingSeat(Request $request)
    {
        $destination = Destination::find($request->destination);
        $totalReservation = $destination->capacity_per_day;
        $experience = Allocation::find($request->allocation);
        $walk_in_capacity = Allocation::find($request->allocation)->capacities->first()->walk_in;
        if($walk_in_capacity > $experience->destination->capacity_per_day) {
            $walk_in_capacity = $experience->destination->capacity_per_day;
        }

        $totalReserved = Book::whereDate('scheduled_at', $request->date)->where('allocation_id', $request->allocation)->sum('total_guest');

        $availableSeat = $walk_in_capacity - $totalReserved;

        return response()->json([
            'walk_in' => $walk_in_capacity,
            'availableSeat' => $availableSeat
        ]);
    }
}
