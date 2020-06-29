<?php

namespace App\Http\Controllers\Admin\Capacities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\ValidationException;

use App\Models\Capacities\Capacity;
use App\Models\Allocations\Allocation;

use App\Http\Requests\Admin\Capacities\CapacityStoreRequest;

class CapacityController extends Controller
{

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Capacities\CapacityMiddleware', 
            ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.capacities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.capacities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CapacityStoreRequest $request)
    {

        $total = $request->online + $request->walk_in + $request->mgt_lgu + $request->agency;
        $capacity_per_day = Allocation::find($request->allocation_id)->destination->capacity_per_day;
        if($total > $capacity_per_day) {
            throw ValidationException::withMessages([
                'capacity_error' => ['Capacity must not greater than to Total Capacity.']
            ]);    
        }
        $item = Capacity::store($request);

        $message = "You have successfully created the capacity of {$item->allocation->name}";
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
        $item = Capacity::withTrashed()->findOrFail($id);
        
        $admin = auth()->guard('admin')->user();
        $show_pagination = true;
        if($admin->destination_id) {
            $show_pagination = false;
            if($item->allocation->destination_id != $admin->destination_id) {
                return back();
            }
        }

        return view('admin.capacities.show', [
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
    public function update(CapacityStoreRequest $request, $id)
    {
        $total = $request->online + $request->walk_in + $request->mgt_lgu + $request->agency;


        $item = Capacity::withTrashed()->findOrFail($id);
        
        if($total > $item->allocation->destination->capacity_per_day) {
            throw ValidationException::withMessages([
                'capacity_error' => ['Capacity must not greater than to Total Capacity.']
            ]);    
        }
        
        $item = Capacity::store($request, $item);

        $message = "You have successfully updated the capacity of {$item->allocation->name}";

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Capacity  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Capacity::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived the capacity of {$item->allocation->name}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Capacity  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Capacity::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored the capacity of {$item->allocation->name}",
        ]);
    }
}
