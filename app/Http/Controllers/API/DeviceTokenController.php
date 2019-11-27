<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Users\DeviceToken;

class DeviceTokenController extends Controller
{
    public function store(Request $request) {
        $token = DeviceToken::where('token',$request->token)->first();
        $user = $request->user();
        if(!$token) {
            $user->deviceTokens()->create([
                'token' => $request->token,
                'platform' => $request->platform
            ]);
        }

        return response()->json([
            'token' => $request->token,
        ]);
    }

    public function update(Request $request, $device_token) {
        $token = DeviceToken::where('token',$device_token)->first();
        $token->update($request->all());
        return response()->json([
            'token' => $request->token,
        ]);
    }
}
