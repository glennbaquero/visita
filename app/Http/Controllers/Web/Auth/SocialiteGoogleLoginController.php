<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Hash;
use Socialite;
use Auth;
use JWTAuth;
use DB;

use App\Helpers\FileHelpers;

use App\Models\Users\User;

class SocialiteGoogleLoginController extends Controller
{
    /**
      * Redirect the user to the Google authentication page.
      *
      * @return \Illuminate\Http\Response
      */
    public function login()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function callback()
    {
        try {
            $socialite = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/sign-in');
        }
        
        // check if they're an existing user
        $existingUser = User::withTrashed()->where('email', $socialite->getEmail())->first();

        if($existingUser){
            /* Check if user is trashed */
            if ($existingUser->deleted_at) {
                abort(403, 'User has been deactivated by the admin.');
            } else {
                // log them in
                $this->guard()->login($existingUser);
            }
        } else {
            // create a new user
            $user = $this->createUser($socialite);

            /* Find existing socialite provider */
            $userProvider = $user->providers()->where('provider', 'google')->first();

            /* Create socialite provider */
            if (!$userProvider) {
            	$userProvider = $user->providers()->updateOrCreate([
            		'provider' => 'google',
            	], [
            		'provider_id' => Hash::make($socialite->getId()),
            	]);
            }

	        $this->guard()->login($user);
        }

        $destination = session('destination');
        $route = $destination ? $destination->renderRequestVisitUrl() : route('web.destinations');

        return redirect($route);
    }

    /**
	 * Create User
	 */
	protected function createUser($socialite) {
		$socialite = json_decode(json_encode($socialite->user));

		return User::create([
			'first_name' => $socialite->given_name,
			'last_name' => $socialite->family_name,
			'email' => $socialite->email,
			'username' => $socialite->email,
			'email_verified_at' => now(),
			'password' => Str::random(),
		]);
	}

	/**
	 * Get guard
	 */
	protected function guard() {
		return Auth::guard('web');
	}
}
