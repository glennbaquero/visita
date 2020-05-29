<?php

namespace App\Http\Controllers\Admin\AboutUs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Models\Pages\AboutUs;

class AboutUsController extends Controller
{
    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\AboutUs\AboutUsMiddleware', 
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
        $show_create = AboutUs::count() ? false : true;

        return view('admin.about-us.index', [
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
        $show_create = AboutUs::count() ? false : true;
        if($show_create) {
            return view('admin.about-us.create');
        } 
        return redirect()->back();
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
            $item = AboutUs::store($request);
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
        $item = AboutUs::withTrashed()->findOrFail($id);
        return view('admin.about-us.show', [
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
        $item = AboutUs::withTrashed()->findOrFail($id);
        DB::beginTransaction();
            $item = AboutUs::store($request, $item);
        DB::commit();

        $message = "You have successfully updated {$item->renderName()}";


        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AboutUs  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = AboutUs::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->title}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\AboutUs  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = AboutUs::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->title}",
        ]);
    }
}
