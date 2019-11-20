<?php

namespace App\Http\Controllers\API\Remarks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Remarks\GroupRemark;

use DB;

class RemarkController extends Controller
{
    public function store(Request $request)
    {
    	DB::beginTransaction();
    		GroupRemark::create($request->all());
    	DB::commit();

    	return response()->json([
    		'success' => true
    	]);
    }
}
