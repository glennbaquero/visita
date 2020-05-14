<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Books\Book;
use App\Models\Guests\Guest;
use App\Models\Remarks\GroupRemark;
use App\Models\Violations\GroupViolation;
use App\Models\Feedbacks\GuestFeedback;
use App\Models\Newsletters\Newsletter;

use Intervention\Image\Facades\Image;

use DB;
use Carbon\Carbon;

class SyncController extends Controller
{
    public function sync(Request $request)
    {
        // scheduled at need to fix
    	$reservation = '';
    	DB::beginTransaction();
    		if($request->table === 'books') {
    			foreach($request->data as $key => $book) {
    				// check if the book id is int
    				if(is_int($book['id'])) {
    					$reservation = Book::find($book['id']);
    					// update the book/reservation
    					$reservation->update([
    						'checked_in_at' => $book['checked_in_at'] ? $this->convertDate($book['checked_in_at']) : null,
    						// 're_scheduled_at' => $book['re_scheduled_at'] ? $book['re_scheduled_at']->format('m-d-y H:i:s') : null,
                            'started_at' => $book['started_at'] ? $this->convertDate($book['started_at']) : null,
    						'start_time' => $book['start_time'] ? $book['start_time'] : null,
    						'ended_at' => $book['ended_at'] ? $this->convertDate($book['ended_at']) : null,
    						'scheduled_at' => $book['scheduled_at'] ? $this->convertDate($book['scheduled_at']) : null,
                            'destination_representative_id' => $book['destination_representative_id']
    					]);
    				} else {
    					// create the book/reservation
    					$reservation = Book::create([
    						'destination_id' => auth()->guard('api')->user()->destination_id,
    						'allocation_id' => json_decode($book['allocation'])->id,
    						'checked_in_at' => $book['checked_in_at'] ? $this->convertDate($book['checked_in_at']) : null,
    						// 're_scheduled_at' => $book['re_scheduled_at'] ? $book['re_scheduled_at']->format('m-d-y H:i:s') : null,
    						'started_at' => $book['started_at'] ? $this->convertDate($book['started_at']) : null,
    						'ended_at' => $book['ended_at'] ? $this->convertDate($book['ended_at']) : null,
    						'scheduled_at' => $book['scheduled_at'] ? $this->convertDate($book['scheduled_at']) : null,
    						'status' => $book['status'],
    						'total_guest' => $book['total_guest'],
    						'is_walkin' => $book['is_walkin'],
    						'created_at' => $book['created_at'],
    						'bookable_id' => auth()->guard('api')->user()->id,
							'bookable_type' => 'App\Models\Users\Management',
							'offline_id' => $book['offline_id'],
                            'start_time' => $book['start_time'] ? $book['start_time'] : null,
                            'destination_representative_id' => $book['destination_representative_id']
    					]);
    				}

					if($request->data[$key]['group_remarks']) {
						// adding of group remark
						foreach (json_decode($request->data[$key]['group_remarks']) as $remark) {
							// check if the remark has an id
							if(!isset($remark->id)) {
								$reservation->groupRemarks()->create([
									'remark' => $remark->remark,
									'statement' => $remark->statement
								]);
							}
						}
					} 
					
					if($request->data[$key]['group_violations']) {
						// adding of group violation
						foreach (json_decode($request->data[$key]['group_violations']) as $violation) {
							// check if the violation has an id
							if(!isset($violation->id)) {
								$reservation->groupViolations()->create([
									'violation' => $violation->violation,
									'statement' => $violation->statement
								]);
							}
						}
					}
    			}
    		}

    		if($request->table === 'guests') {
    			foreach ($request->data as $key => $guest) {
    				$book = Book::where('id', $guest['book_id'])->orWhere('offline_id', $guest['book_id'])->first();
    				// check if the book id is int
    				if(is_int($guest['book_id'])) {
    					$guestWithId = Guest::find($guest['id']);
    					$guestWithId->update([
    						'signature_path' => $guest['signature_path'] ? $this->encodeBase64($guest['signature_path']) : null
    					]);

                        if($guest['opt_in']) {
                            Newsletter::firstOrCreate(['email' => $guestWithId->email]);
                        }
    				} else {
                        Guest::create([
                            'book_id' => $book->id,
                            'special_fee_id' => $guest['special_fee_id'],
                            'visitor_type_id' => $guest['visitor_type_id'],
                            'first_name' => $guest['first_name'],
                            'last_name' => $guest['last_name'],
                            'main' => $guest['main'] == 1 ? 1 : 0,
                            'gender' => $guest['gender'],
                            'nationality' => $guest['nationality'],
                            'email' => $guest['email'],
                            'birthdate' => $guest['birthdate'],
                            'contact_number' => $guest['contact_number'],
                            'emergency_contact_number' => $guest['emergency_contact_number'] ?? null ,
                            'signature_path' => $guest['signature_path'] ? $this->encodeBase64($guest['signature_path']) : null
                        ]);

                        if($guest['opt_in']) {
                            Newsletter::firstOrCreate(['email' => $guest['email']]);
                        }
    				}
    			}
    		}

    		if($request->table === 'guest_feedbacks') {
    			foreach ($request->data as $key => $feedback) {
					$book = Book::where('id', $feedback['book_id'])->orWhere('offline_id', $feedback['book_id'])->first();
                    // if($book->guestFeedbacks()->exists()) {
                    //     $book->guestFeedbacks()->create([
                    //         'feedback_data' => $feedback['feedback_data'],
                    //         'answer' => $feedback['answer'],
                    //         'remarks' => $feedback['remarks']
                    //     ]);
                    // } else {
                        GuestFeedback::create([
                            'book_id' => $book->id,
                            'feedback_data' => $feedback['feedback_data'],
                            'answer' => $feedback['answer'],
                            'remarks' => $feedback['remarks']
                        ]);
                    // }
					
    			}
    		}

            if($request->table === 'invoices') {
                foreach ($request->data as $key => $invoice) {
                    $book = Book::where('id', $invoice['book_id'])->orWhere('offline_id', $invoice['book_id'])->first();
                    $request->user()->invoices()->create([
                        'book_id' => $book->id,
                        'conservation_fee' => $invoice['conservation_fee'],
                        'platform_fee' => $invoice['platform_fee'],
                        'sub_total' => $invoice['sub_total'],
                        'grand_total' => $invoice['grand_total'],
                        'reference_code' => $invoice['reference_code'],
                        'is_paid' => true,
                        'is_approved' => true,
                    ]);
                }
            }
    	DB::commit();

    	return response()->json([
    		'sync' => 'success'
    	]);
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

        $optimized_image = Image::make($base64)->encode($extension);
        $width = $optimized_image->getWidth();
        $height = $optimized_image->getHeight();

        $optimized_image->fit(300, 300);

        $file_path = 'public/signatures/'. str_random(10). '.' . $extension;
        \Storage::put($file_path, $optimized_image);

        return $file_path;
    }


    public function convertDate($date) 
    {
        $date = strtotime($date);

        $newformat = date('Y-m-d H:i:s', $date);

        return $newformat;
    }
}
