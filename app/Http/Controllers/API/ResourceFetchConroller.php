<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceFetchController extends Controller
{
    public function fetch(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'user' => $user,
        ]);
    }
}
