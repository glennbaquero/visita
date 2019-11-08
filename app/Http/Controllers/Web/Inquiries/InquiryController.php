<?php

namespace App\Http\Controllers\Web\Inquiries;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Inquiries\Inquiry;

use App\Http\Requests\Web\Inquiries\InquiryRequest;

use Alert;


class InquiryController extends Controller
{
    public function inquiryPost(InquiryRequest $request)
   {

       // Inquiry::create($request->all());

       // Alert::info('Thanks for contacting us!', 'Success');
       
       // return redirect()->back();

       $item = Inquiry::store($request);

        $message = "Thanks for contacting us!";
        $action = 1;
        $redirect = $item->renderWebHome();

        return response()->json([
            'message' => $message,
            'action' => $action,
            'redirect' => $redirect,
        ]);

        
   }

}
