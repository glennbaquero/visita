<?php

namespace App\Http\Controllers\Admin\Books;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Bookings\BookingStoreRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

use App\Notifications\Frontliner\NewBookingNotification;
use App\Notifications\Reservation\BookingNotification;

use App\Models\Books\Book;
use App\Models\Guests\Guest;
use App\Models\Users\Management;
use App\Models\Emails\GeneratedEmail;

use App\Services\PushService;

use Carbon\Carbon;
use DB;
use Storage;

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
    public function store(BookingStoreRequest $request, $selectedDate, $destination, $experience, $destination_name)
    {
        DB::beginTransaction();
            $item = Book::store($request, null, null, $destination);
            // $item->invoice->create([
                
            // ]);
            
            $upload_path = null;
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
        $qr_email = GeneratedEmail::where('notification_type', 'Booking notification')->first();
        $point_person->notify(new BookingNotification($item, $qr_email));
        $new_booking_frontliner = GeneratedEmail::where('notification_type', 'New booking notification')->first();

        $frontliners = Management::where('destination_id', $destination)->get();
        
        foreach ($frontliners as $key => $frontliner) {
            $frontliner->notify(new NewBookingNotification($item->destination, $item->alloction, $item, $point_person, $new_booking_frontliner));
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
        $submitUrl = route('admin.invoices.update', $item->invoice->id);
        if(!$item->invoice->is_paid && $item->invoice->is_approved && $item->invoice->bank_deposit_slip) {
            $submitUrl = route('admin.invoices.approve.deposit', $item->invoice->id);
        }

        return view('admin.bookings.show', [
            'item' => $item,
            'selectedDate' => $selectedDate,
            'date' => Carbon::parse($selectedDate)->format('F d, Y'),
            'destination' => $destination,
            'destination_name' => $destination_name,
            'experience' => $experience,
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
    public function update(BookingStoreRequest $request, $id,  $selectedDate,$destination, $experience, $destination_name)
    {
        $item = Book::withTrashed()->findOrFail($id);

        DB::beginTransaction();
            $item = Book::store($request, $item, null, $destination);

            // if($request->id) {
                $main = Guest::find($request->main_id);
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
                    'special_fee_id' => $request->special_fee_id,
                ]);     

                if($request->special_fee_path) {
                    $main->update([
                        'special_fee_path' => $this->uploadImage($request->special_fee_path)
                    ]);
                }
            // dd($item ? true : false);
            // }
            
            if($request->guest_first_name) {
                foreach($request->guest_first_name as $key => $guest) {
                    $guest = Guest::find($request->guest_id[$key]);
                    if($guest) {
                        $guest->update([
                            'first_name' => $request->guest_first_name[$key],
                            'last_name' => $request->guest_last_name[$key],
                            'birthdate' => $request->guest_birthdate[$key],
                            'email' => $request->guest_email[$key],
                            'gender' => $request->guest_gender[$key],
                            'contact_number' => $request->guest_contact_number[$key],
                            'emergency_contact_number' => $request->guest_emergency_contact_number[$key],
                            'nationality' => $request->guest_nationality[$key],
                            'visitor_type_id' => $request->guest_visitor_type[$key],
                            'special_fee_id' => $request->guest_special_fee_id[$key],
                        ]);  
                        $upload_path = null;
                        // dd() , $request->input('guest_special_fee_path')[1]);
                        if(isset($request->guest_special_fee_path[$key])) {
                            $guest->update([
                                'special_fee_path' => $this->uploadImage($request->guest_special_fee_path[$key])
                            ]);
                        }
                    } 
                    // else {
                    //     $upload_path = null;
                    //     if($request->guest_special_fee_path[$key]) {
                    //         $file = $request->guest_special_fee_path[$key];
                    //         $filename = $file->getClientOriginalName();
                    //         $path = 'public/special_fee';
                    //         $upload_path = Storage::put($path, $file, $filename);
                    //     }

                    //     $item->guests()->create([
                    //         'first_name' => $request->guest_first_name[$key],
                    //         'last_name' => $request->guest_last_name[$key],
                    //         'birthdate' => $request->guest_birthdate[$key],
                    //         'email' => $request->guest_email[$key],
                    //         'gender' => $request->guest_gender[$key],
                    //         'nationality' => $request->guest_nationality[$key],
                    //         'visitor_type_id' => $request->guest_visitor_type[$key],
                    //         'special_fee_id' => $request->guest_special_fee_id[$key],
                    //         'special_fee_path' => $upload_path,
                    //     ]);  
                    // } 
                }
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

    public function uploadImage($image) {
        $directory = 'special_fees';
        $extension = $image->getClientOriginalExtension() ? $image->getClientOriginalExtension() : 'jpg';
        $optimized_image = Image::make($image)->encode($extension);
        $width = $optimized_image->getWidth();
        $height = $optimized_image->getHeight();

        if ($width >= $height) {
            $optimized_image->resize(700, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } else {
            $optimized_image->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $optimized_image->save();

        switch (config('web.filesystem')) {
            case 's3':
                    $root = null;
                break;
            
            default:
                    $image->store($directory, 'public');
                    $root = 'public/';
                break;
        }

        $file_path = $root . $directory . '/' . uniqid() . Str::random(40) . '.' . $extension;

        Storage::put($file_path, $optimized_image);

        return $file_path;
        
    }

}
