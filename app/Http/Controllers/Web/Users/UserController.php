<?php

namespace App\Http\Controllers\Web\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

use App\Http\Requests\Web\Profiles\ProfileUpdateRequest;

use App\Models\Users\User;
use Hash;
use DB;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, $id)
    {
        $user = User::find($id);
        DB::beginTransaction();
            $user->update($request->except(['old_password', 'password', 'password_confirmation']));
        DB::commit();

        return response()->json([
            'message' => 200
        ]);
    }

    public function updatePassword(Request $request, $id) 
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        $user = User::find($id);
        DB::beginTransaction();
            if(Hash::check($request->old_password, $user->password)) {
                if($request->password === $request->password_confirmation) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                } else {
                    throw ValidationException::withMessages([
                        'password' => ['Password does not match.']
                    ]);
                }
            } else {
                throw ValidationException::withMessages([
                    'old_password' => ['Incorrect old password.']
                ]);
            }
        DB::commit();
        return response()->json([
            'message' => 200
        ]);
    }
}
