<?php

namespace App\Http\Controllers\Admin\BlockedDates;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\BlockedDates\BlockedDate;

use App\Http\Requests\Admin\BlockedDates\BlockedDateStoreRequest;

use DB;

class BlockedDateController extends Controller
{

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\BlockedDates\BlockedDateMiddleware', 
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
        return view('admin.blocked-dates.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blocked-dates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockedDateStoreRequest $request)
    {
        DB::beginTransaction();
        $item = BlockedDate::store($request);

        foreach ($request->dates as $key => $date) {
            if($date != null) {
                $item->dates()->firstOrCreate([ 'date' => $date ]);
            }
        }
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
        $item = BlockedDate::withTrashed()->findOrFail($id);
        return view('admin.blocked-dates.show', [
            'item' => $item,
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
    public function update(BlockedDateStoreRequest $request, $id)
    {
        DB::beginTransaction();
        $item = BlockedDate::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->renderName()}";

        $item = BlockedDate::store($request, $item);
        DB::commit();

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlockedDate  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = BlockedDate::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\BlockedDate  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = BlockedDate::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->renderName()}",
        ]);
    }
}
