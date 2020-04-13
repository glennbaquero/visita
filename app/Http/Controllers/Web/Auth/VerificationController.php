<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Auth;

use App\Models\Users\User;
use App\Models\Users\Management;

use Alert;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web', ['except' => ['verify']]);
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('web.auth.verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if($request->route('user') === 'frontliner') {
            $management = $this->management()->findOrFail($request->route('id'));

            if ($request->route('id') != $management->getKey()) {
                throw new AuthorizationException;
            }

            if ($management->hasVerifiedEmail()) {
                return redirect($this->redirectPath());
            }

            if ($management->markEmailAsVerified()) {

                // $management->setRememberToken(Str::random(60));
                // $token = $management->broker();

                // $token->sendResetLink(collect($management));
                // $management->save();
                // $_token = $token->createToken($management);
                // return redirect()->route('web.frontliner.password.reset', [$_token, $management->email]);
                // $this->guard()->login($management);
                event(new Verified($management));
            }
        } else {
            $user = $this->user()->findOrFail($request->route('id'));

            if ($request->route('id') != $user->getKey()) {
                throw new AuthorizationException;
            }

            if ($user->hasVerifiedEmail()) {
                return redirect($this->redirectPath());
            }

            if ($user->markEmailAsVerified()) {
                $this->guard()->login($user);
                event(new Verified($user));
            }
        }

        return redirect($this->redirectPath())->with('verified', true);
    }

    protected function user() {
        return new User;
    }

    protected function management() {
        return new Management;
    }

    protected function guard() {
        return Auth::guard('web');
    }
}
