<?php

namespace App\Http\Controllers\Admin\AddOns;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\AddOns\AddOn;

use App\Http\Requests\Admin\AddOns\AddOnStoreRequest;

class AddOnController extends Controller
{

     public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\AddOns\AddOnMiddleware', 
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
        return view('admin.add-ons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add-ons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddOnStoreRequest $request)
    {
        $item = AddOn::store($request);

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
        $item = AddOn::withTrashed()->findOrFail($id);
        return view('admin.add-ons.show', [
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
    public function update(AddOnStoreRequest $request, $id)
    {
        $item = AddOn::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->renderName()}";

        $item = AddOn::store($request, $item);

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AddOn  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = AddOn::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\AddOn  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = AddOn::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->renderName()}",
        ]);
    }
}
