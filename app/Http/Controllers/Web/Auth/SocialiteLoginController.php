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

class SocialiteLoginController extends Controller
{
	const SCOPES = [
        //
    ];

	const FIELDS = [
        'id',
        'first_name', // Default
        'last_name', // Default
        'email', // Default
    ];

	/**
	* Create a redirect method to facebook api.
	*
	* @return void
	*/
    public function login(Request $request, $provider)
    {
        return Socialite::driver($provider)->scopes(static::SCOPES)->fields(static::FIELDS)->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(Request $request, $provider)
    {
    	if (!$request->has('code') || $request->has('denied')) {
		    return redirect('/sign-in');
		}

    	try {
		    $socialite = Socialite::driver($provider)->scopes(static::SCOPES)->fields(static::FIELDS)->user();
    	} catch (InvalidStateException $e) {
    		$request->session()->invalidate();
    		abort(403, 'Invalid provider token, please try again');
    	}

    	$request->session()->regenerate();

		$token = $this->authenticate($socialite, $provider);

		$destination = session('destination');
        $route = $destination ? $destination->renderRequestVisitUrl() : route('web.destinations');

		return redirect($route);
    }

	public function authenticate($socialite, $provider) {
		DB::beginTransaction();

		$avatar_url = $socialite->getAvatar();

		/* Find user base on provider email */
		$user = User::withTrashed()->where('email', $socialite->getEmail())->first();

		/* Create user if does not exists */
		if (!$user) {
			$user = $this->createUser($socialite);
			// $user->storeImage(FileHelpers::getExternalImage($avatar_url), 'image_path', 'user-avatars');
		}

		/* Check if user is trashed */
		if ($user->deleted_at) {
			abort(403, 'User has been deactivated by the admin.');
		}

		/* Find existing socialite provider */
		$userProvider = $user->providers()->where('provider', $provider)->first();

		/* Create socialite provider */
		if (!$userProvider) {
			$userProvider = $user->providers()->updateOrCreate([
				'provider' => $provider,
			], [
				'provider_id' => Hash::make($socialite->getId()),
			]);
		}

		/* Check if socialite id matches */
		if (!Hash::check($socialite->getId(), $userProvider->provider_id)) {
			abort(403, 'Invalid provider credentials');
		}

		/* Generate token and login */
		$token = 'Bearer ' . JWTAuth::fromSubject($user);
        $this->guard()->login($user);

        DB::commit();


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
			'first_name' => $socialite->first_name,
			'last_name' => $socialite->last_name,
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
