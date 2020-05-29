<?php

namespace App\Http\Controllers\Admin\CivilStatuses;

use App\Http\Requests\Admin\CivilStatuses\CivilStatusStoreRequest;
use App\Http\Controllers\Controller;

use App\Models\CivilStatuses\CivilStatus;

class CivilStatusController extends Controller
{
    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\CivilStatus\CivilStatusMiddleware', 
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
        return view('admin.civil_statuses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.civil_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CivilStatusStoreRequest $request)
    {
        $item = CivilStatus::store($request);

        $message = "You have successfully created {$item->name}";
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
        $item = CivilStatus::withTrashed()->findOrFail($id);
        return view('admin.civil_statuses.show', [
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
    public function update(CivilStatusStoreRequest $request, $id)
    {
        $item = CivilStatus::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->question}";

        $item = CivilStatus::store($request, $item);

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CivilStatus  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = CivilStatus::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->question}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\CivilStatus  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = CivilStatus::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->name}",
        ]);
    }
}
