<?php

namespace App\Http\Controllers\API\Frontliner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Update frontliner basic details
     * 
     * @param Illuminate\Http\Request
     * @return json $response
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:managements,email,'. $request->user()->id,
            'contact_number' => 'required',
        ]);
        
        \DB::beginTransaction();

            $request->user()->update($request->all());

        \DB::commit();

        return response()->json([
            'message' => 'Profile successfully updated!',
            'user' => $request->user(),
        ]);
    }
}
