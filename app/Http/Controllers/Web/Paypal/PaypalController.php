<?php

namespace App\Http\Controllers\Web\Paypal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaypalController extends Controller
{
    public function transaction(Request $request)
    {
    	return redirect()->route('web.dashboard');
    	// return view('web.pages.user.dashboard', [
     //    	'page_scripts'=> 'dashboard'
     //    ]);
    }
}
