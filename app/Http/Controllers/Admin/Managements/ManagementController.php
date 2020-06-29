<?php

namespace App\Http\Controllers\Admin\Managements;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Users\Management;

use App\Http\Requests\Admin\Managements\ManagementStoreRequest;

use DB;

class ManagementController extends Controller
{
    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Managements\ManagementMiddleware', 
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
        return view('admin.managements.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.managements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManagementStoreRequest $request)
    {
        DB::beginTransaction();
            $item = Management::store($request);
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
        $item = Management::withTrashed()->findOrFail($id);
        $admin = auth()->guard('admin')->user();
        $show_pagination = true;
        if($admin->destination_id) {
            $show_pagination = false;
            if($item->destination_id != $admin->destination_id) {
                return back();
            }
        }

        return view('admin.managements.show', [
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
    public function update(ManagementStoreRequest $request, $id)
    {
        $item = Management::withTrashed()->findOrFail($id);
        DB::beginTransaction();
            $item = Management::store($request, $item);
        DB::commit();

        $message = "You have successfully updated {$item->renderName()}";


        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Management  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Management::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Management  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Management::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->renderName()}",
        ]);
    }
}
