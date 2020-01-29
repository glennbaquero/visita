<?php

namespace App\Http\Controllers\API\Masungi\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Log;

use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Hash;
use Auth;

use App\Models\API\Masungi;

use App\Http\Controllers\API\Masungi\Invoices\InvoiceController;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public function redirectToLogin(Request $request, $option) 
    {
    	$request['api_key'] = config('visita.api_key');
    	$request['api_secret'] = config('visita.api_secret');
    	return $this->login($request, $option);
    }

    /**
     * Fetch the auth token of the specified user
     * @return JSON
     */
    public function login(Request $request, $option)
    {
        $token = null;
        $action = false;
        $api_key = $request->input('api_key');
        $api_secret = $request->input('api_secret');
        $user = Masungi::where(['api_key' => $api_key, 'api_secret' => $api_secret])->first();

        /* Short circuit if no user found with requested username */
        if (!$user) {
            $appName = config('app.name');

            return "key is not valid or secret is not valid. Api Key (".$api_key.") Api Secret (".$api_secret.")";
        }

        // $response = Hash::check($request->input('password'), $user->password);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $token = JWTAuth::fromSubject($user);

    	$invoiceController = new InvoiceController;
        
        if($option === 'book') {
        	// $invoiceController->store($request, $user);
        	$response = $invoiceController->store($request, $user);
        } elseif ($option === 'fetch') {
        	// if(!$request->user_id) {
        	// 	return 1;
        	// }
            // $response = $invoiceController->showReservations($request->user_id, $user);
        	$response = $invoiceController->showReservations($user);
        } elseif($option === 'update') {
        	$response = $invoiceController->paypalPaid($request);
            Log::info($request);
        }

        return $response;
    }

    /**
     * Used on ThrottlesLogins
     * @return string username
     */
    public function username() {
        return 'username';
    }
}
