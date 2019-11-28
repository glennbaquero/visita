<?php

namespace App\Http\Controllers\Admin\TrainingModules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TrainingModules\TrainingModule;

use App\Http\Requests\Admin\TrainingModules\TrainingModuleStoreRequest;

use App\Notifications\Frontliner\TrainingModuleNotification;

use App\Models\Users\Management;
use DB;


class TrainingModuleController extends Controller
{

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\TrainingModules\TrainingModuleMiddleware', 
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
        return view('admin.training-modules.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.training-modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrainingModuleStoreRequest $request)
    {
        DB::beginTransaction();
            $item = TrainingModule::store($request);

            if($request->destination_id) {     
                    foreach($item->destination->managements as $receiver) {
                        $receiver->notify(new TrainingModuleNotification($item->title, $item->description, $item->renderFilePath('path')));
                    }
            } else {
                $managements = Management::all();
                foreach ($managements as $receiver) {
                    $receiver->notify(new TrainingModuleNotification($item->title, $item->description, $item->renderFilePath('path')));
                }
            }
        DB::commit();
        $message = "You have successfully created {$item->title}";
        $redirect = $item->renderShowUrl();

        // dd($request->renderFile());

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
        $item = TrainingModule::withTrashed()->findOrFail($id);
        return view('admin.training-modules.show', [
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
    public function update(TrainingModuleStoreRequest $request, $id)
    {
        $item = TrainingModule::withTrashed()->findOrFail($id);
  
        DB::beginTransaction();
            $item = TrainingModule::store($request, $item);
        DB::commit();
        $message = "You have successfully updated {$item->title}";

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TrainingModule  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = TrainingModule::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->title}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\TrainingModule  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = TrainingModule::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->title}",
        ]);
    }
}
