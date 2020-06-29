<?php

namespace App\Http\Controllers\Admin\Destinations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Destinations\Destination;

use App\Http\Requests\Admin\Destinations\DestinationStoreRequest;

use DB;

class DestinationController extends Controller
{

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Destinations\DestinationMiddleware', 
            ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore', 'removeImage']]
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
        $show_create = true;
        if($admin->destination_id) {
            $show_create = false;
        }

        return view('admin.destinations.index',[
            'show_create' => $show_create
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.destinations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DestinationStoreRequest $request)
    {
        DB::beginTransaction();
            $item = Destination::store($request);
            $item->addOns()->attach($request->add_ons);
        DB::commit();
        $message = "You have successfully created {$item->renderName()}";
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
        $item = Destination::withTrashed()->findOrFail($id);

        $admin = auth()->guard('admin')->user();
        $show_create = true;
        if($admin->destination_id) {
            $show_create = false;
            if($id != $admin->destination_id) {
                return back();
            }
        }
        return view('admin.destinations.show', [
            'item' => $item,
            'show_create' => $show_create,
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
    public function update(DestinationStoreRequest $request, $id)
    {
        $item = Destination::withTrashed()->findOrFail($id);
        $old_capacity = $item->capacity_per_day;
        DB::beginTransaction();
            $item = Destination::store($request, $item);
            $item->addOns()->sync($request->add_ons);
            $new_capacity = $item->capacity_per_day;
        DB::commit();

        $message = "You have successfully updated {$item->renderName()}. If capacity has changes please update the capacity in each experience.";


        return response()->json([
            'message' => $message,
            'old' => $old_capacity,
            'new' => $new_capacity,
            'show_capacity_tab' => $old_capacity != $new_capacity, 
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
        $item = Destination::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
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
        $item = Destination::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->renderName()}",
        ]);
    }

    public function removeImage(Request $request, $id)
    {
        $item = Destination::withTrashed()->findOrFail($id);
        $message = "You have successfully remove the image in {$item->renderName()}";

        $result = $item->removeImage($request);

        return response()->json([
            'message' => $message,
        ]);
    }
}
