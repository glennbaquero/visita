<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\LoginRequest;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Hash;
use Auth;

use App\Models\Users\User;

class LoginController extends Controller
{
    use ThrottlesLogins;

    /**
     * Fetch the auth token of the specified user
     * @return JSON
     */
    public function login(LoginRequest $request)
    {
        $token = null;
        $action = false;
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        /* Short circuit if no user found with requested email */
        if (!$user) {
            $appName = config('app.name');

            throw ValidationException::withMessages([
                'email' => "{$email} is not associated with any {$appName} account.",
            ]);
        }

        $response = Hash::check($request->input('password'), $user->password);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        /* Short circuit if password doesn't match */
        if (!$response) {
            $this->incrementLoginAttempts($request);

            throw ValidationException::withMessages([
                'password' => "The password you've entered is incorrect.",
            ]);
        }
        
        $token = JWTAuth::fromSubject($user);

        return response()->json([
            'token' => 'Bearer ' . $token,
        ]);
    }

    /**
     * Used on ThrottlesLogins
     * @return string username
     */
    public function username() {
        return 'email';
    }
}
