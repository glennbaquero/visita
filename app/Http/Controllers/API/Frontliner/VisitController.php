<?php

namespace App\Http\Controllers\API\Frontliner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Books\Book;
Use App\Models\Guests\Guest;
use Carbon\Carbon;

class VisitController extends Controller
{
    /**
     * Start visit for the booking
     * 
     * @param Illuminate\Http\Request
     * @return json $response
     */
    public function start(Request $request)
    {
        // Book::find($request->id)->update(['started_at' => Carbon::now()]);

        foreach($request->guests as $item) {
            
            $image = $item['signature_path'];  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            $path = \File::put(storage_path() . '/app/signatures/' . $imageName, base64_decode($image));

            Guest::find($item['id'])->update([
                'signature_path' => 'storage/app/signatures/' . $imageName
            ]);
        }

        return response()->json(['message' => 'Success']);
    }
}
