<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Destinations\Destination;
use App\Models\Allocations\Allocation;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = auth()->guard('admin')->user();
    	$destinations = Destination::with('allocations')->get();
    	if($admin->destination_id) {
    	    $destinations = Destination::where('id', $admin->destination_id)->with('allocations')->get();
    	}
        return view('admin.dashboards.index', [
        	'destinations' => $destinations,
        ]);
    }
}
