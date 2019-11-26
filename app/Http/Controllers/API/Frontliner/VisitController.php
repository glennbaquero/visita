<?php

namespace App\Http\Controllers\API\Frontliner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

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
            
            // $image = $item['signature_path'];  // your base64 encoded
            // $image = str_replace('data:image/png;base64,', '', $image);
            // $image = str_replace(' ', '+', $image);
            // $imageName = str_random(10).'.'.'png';
            // $path = \File::put(storage_path() . '/app/signatures/' . $imageName, base64_decode($image));
            // return $path;
            $guest = Guest::find($item['id'])->update([
                'signature_path' => $this->encodeBase64($item['signature_path'])
            ]);
        }

        $book = Book::find($request->id);
        $book->update([
            'started_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Success']);
    }

     public function encodeBase64($base64, $filename = null)
    {   
        $extension = 'png';
        $replaceableString = explode(',', $base64); 
        
        if($filename) {
            $extension = explode('.', $filename);
            $extension = $extension[1];
        }

        $base64 = str_replace($replaceableString[0] . ',' , '', $base64);
        $base64 = str_replace(' ', '+', $base64);
        $base64 = base64_decode($base64);

        $optimized_image = Image::make($base64)->encode('png');
        $width = $optimized_image->getWidth();
        $height = $optimized_image->getHeight();

        $optimized_image->fit(300, 300);

        $file_path = 'public/signatures/'. str_random(10). '.png';
        \Storage::put($file_path, $optimized_image);

        return $file_path;
    }
}
