<?php

namespace App\Http\Controllers\Admin\TimeSlots;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Timeslots\TimeslotStoreRequest;
use App\Http\Controllers\Controller;

use App\Models\Times\TimeSlot;
use App\Models\Allocations\Allocation;

class TimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.timeslots.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.timeslots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimeslotStoreRequest $request)
    {
        $item = TimeSlot::store($request);

        $message = "You have successfully created {$item->time}";
        $redirect = $item->renderShowUrl();

        return response()->json([
            'message' => $message,
            'redirect' => $redirect,
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
        $item = TimeSlot::withTrashed()->findOrFail($id);
        $admin = auth()->guard('admin')->user();
        $show_pagination = true;
        if($admin->destination_id) {
            $show_pagination = false;
            if($item->allocation->destination_id != $admin->destination_id) {
                return back();
            }
        }
        return view('admin.timeslots.show', [
            'item' => $item,
            'show_pagination' => $show_pagination,
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
    public function update(TimeslotStoreRequest $request, $id)
    {
        $item = TimeSlot::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->time}";

        $item = TimeSlot::store($request, $item);

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TimeSlot  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = TimeSlot::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->time}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\TimeSlot  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = TimeSlot::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->time}",
        ]);
    }
}
