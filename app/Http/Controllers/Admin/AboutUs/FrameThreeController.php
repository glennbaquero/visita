<?php

namespace App\Http\Controllers\Admin\AboutUs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Models\Pages\AboutUsFrameThree;

class FrameThreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.frame-three.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frame-three.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
            $item = AboutUsFrameThree::store($request);
        DB::commit();
        $message = "You have successfully created {$item->title}";
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
        $item = AboutUsFrameThree::withTrashed()->findOrFail($id);
        return view('admin.frame-three.show', [
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
    public function update(Request $request, $id)
    {
        $item = AboutUsFrameThree::withTrashed()->findOrFail($id);
        DB::beginTransaction();
            $item = AboutUsFrameThree::store($request, $item);
        DB::commit();

        $message = "You have successfully updated {$item->title}";


        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AboutUsFrameThree  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = AboutUsFrameThree::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->title}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\AboutUsFrameThree  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = AboutUsFrameThree::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->title}",
        ]);
    }
}
