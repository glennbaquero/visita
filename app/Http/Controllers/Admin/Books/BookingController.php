<?php

namespace App\Http\Controllers\Admin\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Destinations\Destination;

class BookingController extends Controller
{
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

        return view('admin.bookings-all.index', [
            'destinations' => $destinations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $destination = $request->destination_id;

        DB::beginTransaction();
            $item = Book::store($request, null, null, $destination);
            
            if($request->special_fee_path) {
                $file = $request->special_fee_path;
                $filename = $file->getClientOriginalName();
                $path = 'public/special_fee';
                $upload_path = Storage::putFileAs($path, $file, $filename);
            }

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
                    'special_fee_id' => $request->special_fee_id,
                    'special_fee_path' => $upload_path,
                    'main' => true
                ]);
            if($request->guest_first_name) {
                foreach($request->guest_first_name as $key => $guest) {
                    if($request->guest_special_fee_path[$key]) {
                        $file = $request->guest_special_fee_path[$key];
                        $filename = $file->getClientOriginalName();
                        $path = 'public/special_fee';
                        $upload_path = Storage::putFileAs($path, $file, $filename);
                    }

                    $item->guests()->create([
                        'first_name' => $request->guest_first_name[$key],
                        'last_name' => $request->guest_last_name[$key],
                        'birthdate' => $request->guest_birthdate[$key],
                        'email' => $request->guest_email[$key],
                        'gender' => $request->guest_gender[$key],
                        'nationality' => $request->guest_nationality[$key],
                        'visitor_type_id' => $request->guest_visitor_type[$key],
                        'special_fee_id' => $request->guest_special_fee_id[$key],
                        'special_fee_path' => $upload_path,
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
    public function show($id)
    {
        $item = Book::withTrashed()->findOrFail($id);
        $submitUrl = route('admin.invoices.update', $item->invoice->id);
        if(!$item->invoice->is_paid && $item->invoice->is_approved && $item->invoice->bank_deposit_slip) {
            $submitUrl = route('admin.invoices.approve.deposit', $item->invoice->id);
        }

        return view('admin.bookings.show', [
            'item' => $item,
            'submitUrl' => $submitUrl,
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
    public function update(Request $request, $id)
    {
        $item = Book::withTrashed()->findOrFail($id);
        $destination = $request->destination_id;

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
