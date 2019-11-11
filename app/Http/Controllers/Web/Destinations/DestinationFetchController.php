<?php

namespace App\Http\Controllers\Web\Destinations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Destinations\Destination;

class DestinationFetchController extends Controller
{
    public function fetchDestination() {

        $destinations = Destination::all();

        return response()->json([
        	'destinations' => $destinations
        ]);
        
	}
}
