<?php

namespace App\Http\Controllers\API\Feedbacks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Books\Book;
use App\Models\Feedbacks\GuestFeedback;

use DB;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
    	DB::beginTransaction();
    		$book = Book::find($request->book_id);
            if(!$request->skip) {
                foreach ($request->feedbacks as $feedback) {
                    $book->guestFeedbacks()->create([
                        'answer' => $feedback['selected'],
                        'remarks' => $feedback['remarks'],
                        'feedback_data' => json_encode($feedback)
                    ]);
                }
            }

    		$book->ended_at = Carbon::now();
            $book->status = true;
    		$book->save();
    	DB::commit();

    	return response()->json([
    		'success' => true
    	]);
    }
}
