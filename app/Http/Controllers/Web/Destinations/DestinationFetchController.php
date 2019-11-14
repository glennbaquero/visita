<?php

namespace App\Http\Controllers\Web\Destinations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Destinations\Destination;

class DestinationFetchController extends Controller
{
    public function fetchDestination() {

        $destination = Destination::with('experiences')->get();
        // $destination->picture = $destination->pictures()->first()->renderImagePath();

        return response()->json([
        	'destination' => $destination
        ]);
        
	}
}
