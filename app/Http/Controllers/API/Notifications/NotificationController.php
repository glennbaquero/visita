<?php

namespace App\Http\Controllers\API\Notifications;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification as Notification;

use App\Http\Controllers\Controller;

use DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Fetch all notifications
     * 
     * @return json $response 
     */
    public function fetch()
    {
        $user = request()->user();

        return response()->json([
            'notifications' => $user->notifications()->paginate(99999999)
        ]);
    }

    /**
     * Read Notificationn
     * 
     * @param Illuminate\Http\Request
     * @return json $response
     */
    public function read(Request $request)
    {
        DB::beginTransaction();
            Notification::find($request->id)->update(['read_at' => Carbon::now()]);
        DB::commit();
        
        $user = request()->user();

        return response()->json([
            'notifications' => $user->notifications()->paginate(10)
        ]);
    }
}
