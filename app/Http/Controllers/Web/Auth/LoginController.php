<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\Pages\Page;

use Auth;


class LoginController extends Controller
{
     use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/destinations';
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {

        $page = Page::where('slug', 'login')->first();

        $data = $page->getData();
        
        return view('web.auth.login', [ 
            'data' => $data, 
            'provider' => 'facebook',
            'page_scripts'=> 'login'
        ]);

    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // if (!$user->hasVerifiedEmail()) {
        //     auth()->logout();
        //     return redirect()->back();
            // activity()
            //     ->causedBy($user)
            //     ->performedOn($user)
            //     ->log('Account has been logged in.');
        // }
        
        if($user->email_verified_at == null) {
            \Auth::logout();
            return redirect()->route('web.destinations');
        }

        $destination = session('destination');
        $route = $destination ? $destination->renderRequestVisitUrl() : route('web.destinations');
        
        return redirect($route);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }
}