<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\API\Auth\RegisterPost;

use DB;
use JWTAuth;

use App\User;

class RegisterController extends Controller
{
    public function register(RegisterPost $request)
    {   
        DB::beginTransaction();

        	$user = User::createData($request);

        DB::commit();

        $token = JWTAuth::fromSubject($user);

    	return response()->json([
            'token' => 'Bearer ' . $token,
    		'message' => 'Registation complete, kindly check your email to verify account.',
    	]);
    }
}
