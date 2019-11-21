<?php

namespace App\Http\Controllers\API\Violations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Violations\GroupViolation;

use DB;


class ViolationController extends Controller
{
     public function store(Request $request)
    {
    	DB::beginTransaction();
    		GroupViolation::create($request->all());
    	DB::commit();

    	return response()->json([
    		'success' => true
    	]);
    }
}
