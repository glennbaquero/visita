<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SortableController extends Controller
{
    public function sort(Request $request) {

    	if ($request->filled('image')) {
    		$model = 'App\Models\Picture';
    	}
    	
        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model))) {
            $old = $model::withTrashed()->findOrFail($request->input('old'));
            $new = $model::withTrashed()->findOrFail($request->input('new'));
        } else {
            $old = $model::findOrFail($request->input('old'));
            $new = $model::findOrFail($request->input('new'));
        }
    	
    	$model::swapOrder($old, $new);

    	return response()->json(true);
    }
}
