<?php

namespace App\Http\Controllers\Admin\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Notifications\Frontliner\NewBookingNotification;
use App\Notifications\Reservation\BookingNotification;

use App\Models\Books\Book;
use App\Models\Guests\Guest;
use App\Models\Users\Management;

use App\Services\PushService;

use Carbon\Carbon;
use DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($selectedDate, $destination, $experience, $destination_name)
    {
        return view('admin.bookings.index', [
            'selectedDate' => $selectedDate,
            'date' => Carbon::parse($selectedDate)->format('F d, Y'),
            'destination' => $destination,
            'destination_name' => $destination_name,
            'experience' => $experience
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($selectedDate, $destination, $experience, $destination_name)
    {
        return view('admin.bookings.create', [
            'selectedDate' => $selectedDate,
            'date' => Carbon::parse($selectedDate)->format('F d, Y'),
            'destination' => $destination,
            'destination_name' => $destination_name,
            'experience' => $experience
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $selectedDate, $destination, $experience, $destination_name)
    {
        DB::beginTransaction();
            $item = Book::store($request, null, null, $destination);

            $item->guests()->create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'birthdate' => $request->birthdate,
                    'gender' => $request->gender,
                    'nationality' => $request->nationality,
                    'contact_number' => $request->contact_number,
                    'emergency_contact_number' => $request->emergency_contact_number,
                    'email' => $request->email,
                    'visitor_type_id' => $request->visitor_type_id,
                    'main' => true
                ]);
            if($request->guest_first_name) {
                foreach($request->guest_first_name as $key => $guest) {
                    $item->guests()->create([
                        'first_name' => $request->guest_first_name[$key],
                        'last_name' => $request->guest_last_name[$key],
                        'birthdate' => $request->guest_birthdate[$key],
                        'email' => $request->guest_email[$key],
                        'gender' => $request->guest_gender[$key],
                        'nationality' => $request->guest_nationality[$key],
                        'visitor_type_id' => $request->guest_visitor_type[$key],
                        'special_fee_id' => $request->guest_special_fee_id[$key],
                    ]);   
                }
            }
        DB::commit();
        
        $point_person = $item->guests()->where('main', true)->first();
        $point_person->notify(new BookingNotification($item));

        $frontliners = Management::where('destination_id', $destination)->get();
        
        foreach ($frontliners as $key => $frontliner) {
            $frontliner->notify(new NewBookingNotification($request));
        }
        $receiver = new PushService('New Reservation', 'A new reservation of visitor for '.Carbon::parse($request->scheduled_at)->format('M d, Y'). '.');
        $receiver->pushToMany($frontliners);

        $message = "You have successfully created a new reservation";
        $redirect = $item->renderShowUrl();
        return response()->json([
            'message' => $message,
            'redirect' => $redirect.'/'.$selectedDate.'/'.$destination.'/'.$experience.'/'.$destination_name,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $selectedDate,$destination, $experience, $destination_name)
    {
        $item = Book::withTrashed()->findOrFail($id);

        return view('admin.bookings.show', [
            'item' => $item,
            'selectedDate' => $selectedDate,
            'date' => Carbon::parse($selectedDate)->format('F d, Y'),
            'destination' => $destination,
            'destination_name' => $destination_name,
            'experience' => $experience
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,  $selectedDate,$destination, $experience, $destination_name)
    {
        $item = Book::withTrashed()->findOrFail($id);

        DB::beginTransaction();
            $item = Book::store($request, $item, null, $destination);

            if($request->id) {
                $main = Guest::find($request->id);
                $main->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'birthdate' => $request->birthdate,
                    'gender' => $request->gender,
                    'nationality' => $request->nationality,
                    'contact_number' => $request->contact_number,
                    'emergency_contact_number' => $request->emergency_contact_number,
                    'email' => $request->email,
                    'visitor_type_id' => $request->visitor_type_id,
                ]);     
            }
            
            foreach($request->guest_first_name as $key => $guest) {
                $guest = Guest::find($request->guest_id[$key]);
                $guest->update([
                    'first_name' => $request->guest_first_name[$key],
                    'last_name' => $request->guest_last_name[$key],
                    'birthdate' => $request->guest_birthdate[$key],
                    'email' => $request->guest_email[$key],
                    'gender' => $request->guest_gender[$key],
                    'nationality' => $request->guest_nationality[$key],
                    'visitor_type_id' => $request->guest_visitor_type[$key],
                    'special_fee_id' => $request->guest_special_fee_id[$key],
                ]);   
            }

        DB::commit();

        $message = "You have successfully updated the reservation";

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Destination  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Book::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived the reservation",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Destination  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Book::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored the reservation",
        ]);
    }
}
