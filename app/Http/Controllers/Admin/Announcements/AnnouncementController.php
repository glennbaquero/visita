<?php

namespace App\Http\Controllers\Admin\Announcements;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Notifications\Frontliner\AnnouncementNotification;

use App\Http\Requests\Admin\Announcements\AnnouncementStoreRequest;

use App\Services\PushService;

use App\Models\Announcements\Announcement;
use App\Models\Users\Management;
use DB;

class AnnouncementController extends Controller
{
    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Announcements\AnnouncementMiddleware', 
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
        return view('admin.announcements.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementStoreRequest $request)
    {
        DB::beginTransaction();
            $item = Announcement::store($request);
            if($request->destination_ids) {
                $item->destinations()->sync($request->destination_ids);
                foreach($item->destinations as $destination) {
                    foreach($destination->managements as $receiver) {
                        $receiver->notify(new AnnouncementNotification($request->except(['destination_ids'])));
                    }
                    $receiver = new PushService('Announcement', 'A new announcement has arrived!');
                    $receiver->pushToMany($destination->managements);
                }
            } else {
                $managements = Management::all();
                foreach ($managements as $receiver) {
                    $receiver->notify(new AnnouncementNotification($request->except(['destination_ids'])));
                }

                $receiver = new PushService('Announcement', 'A new announcement has arrived!');
                $receiver->pushToMany($managements);
            
            }
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
        $item = Announcement::withTrashed()->findOrFail($id);
        return view('admin.announcements.show', [
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
    public function update(AnnouncementStoreRequest $request, $id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->title}";

        $item = Announcement::store($request, $item);

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Announcement  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->title}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Announcement  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->title}",
        ]);
    }
}
