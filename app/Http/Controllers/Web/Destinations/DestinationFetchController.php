<?php

namespace App\Http\Controllers\Web\Destinations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Destinations\Destination;

class DestinationFetchController extends Controller
{
    public function fetchDestination() {
    	$result = [];
        $destinations = Destination::with('experiences')->get();
        foreach ($destinations as $key => $destination) {
        	array_push($result, [
        		'destination' => $destination,
        		'id' => $destination->id,
        		'name' => $destination->name,
        		'short_description' => str_limit($destination->overview, 70),
        		'capacity' => $destination->capacity,
        		'image' => $destination->pictures->first()->renderImagePath()
        	]);
        }
        return response()->json([
        	'destinations' => $result
        ]);
        
	}
}
