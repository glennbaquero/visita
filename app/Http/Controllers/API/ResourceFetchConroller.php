<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\API\FetchControllers\NationalityFetchController;
use App\Http\Controllers\API\FetchControllers\ExperienceFetchController;
use App\Http\Controllers\API\FetchControllers\VisitorTypeFetchController;
use App\Http\Controllers\API\FetchControllers\ReligionFetchController;
use App\Http\Controllers\API\FetchControllers\TrainingModuleFetchController;
use App\Http\Controllers\API\FetchControllers\SurveyFetchController;
use App\Http\Controllers\API\FetchControllers\AnnualIncomeFetchController;
use App\Http\Controllers\API\FetchControllers\FeedbackFetchController;

use App\Models\Fees\Fee;
use App\Models\Books\Book;
use App\Models\Guests\Guest;
use App\Models\Faqs\Faq;
use App\Models\Remarks\Remark;
use App\Models\Violations\Violation;
use App\Models\Users\Management;
use App\Models\BlockedDates\BlockedDate;
use Carbon\Carbon;

class ResourceFetchController extends Controller
{
    public function fetch(Request $request)
    {
        $user = $request->user();

        $fetch_nationalities = new NationalityFetchController($request);
        $fetch_experiences = new ExperienceFetchController($request);
        $fetch_types = new VisitorTypeFetchController($request);
        $fetch_religions = new ReligionFetchController($request);
        $fetch_training_modules = new TrainingModuleFetchController($request);
        $fetch_surveys = new SurveyFetchController($request);
        $fetch_incomes = new AnnualIncomeFetchController($request);
        $fetch_feedbacks = new FeedbackFetchController($request);

        $nationalities = $fetch_nationalities->fetch($request);
        $experiences = $fetch_experiences->fetch($request);
        $visitor_types = $fetch_types->fetch($request);
        $religions = $fetch_religions->fetch($request);
        $training_modules = $fetch_training_modules->fetch($request);
        $surveys = $fetch_surveys->fetch($request);
        $incomes = $fetch_incomes->fetch($request);
        $feedbacks = $fetch_feedbacks->fetch($request);
        $faqs = Faq::all();
        $remarks = Remark::all();
        $violations = Violation::all();
        $blocked_dates = BlockedDate::all();
        $management = Management::where('role_id', 5)->where('destination_id', $request->user()->destination_id)->get();
        $bookings = $this->getBookings();
        $guests = $this->getGuests();
        $destination = auth()->guard('api')->user()->destination;

        return response()->json([
            'user' => $user,
            'nationalities' => $nationalities->original['items'],
            'experiences' => $experiences->original['items'],
            'visitor_types' => $visitor_types->original['items'],
            'religions' => $religions->original['items'],
            'training_modules' => $training_modules->original['items'],
            'surveys' => $surveys->original['items'],
            'incomes' => $incomes->original['items'],
            'feedbacks' => $feedbacks->original['items'],
            'faqs' => $faqs,
            'remarks' => $remarks,
            'violations' => $violations,
            'management' => $management,
            'bookings' => $bookings,
            'guests' => $guests,
            'blocked_dates' => $blocked_dates,
            'destination' => $destination,
        ]);
    }

    /**
     * Get the data of the dashboard of specific destination based on today's date
     */
    public function dashboard(Request $request)
    {
    	$today = Carbon::now();
    	// get current user login
    	$user = $request->user();

    	// get all booking based on current destination assigned for logged-in user
    	$bookings = Book::where('destination_id', $user->destination->id)->whereDate('scheduled_at', $today);
    	
    	// total of guest today
    	$total['guest'] = $bookings->get()->sum('total_guest');

    	// total of groups today
    	$total['groups'] = $bookings->get()->count();
    	
    	// get total checked in for walk in guest
    	$checked_in_walkin['visitors'] = $bookings->where('is_walkin', true)->whereDate('started_at', $today)->get()->count(); 
    	$checked_in_walkin['groups'] = $bookings->where('is_walkin', true)->whereDate('started_at', $today)->get()->count(); 

    	// get total checked in for online in guest
        $total_checked_in['online_visitor'] = $bookings->where('is_walkin', false)->whereDate('started_at', $today)->get()->count(); 
        $total_checked_in['online_group'] = $bookings->where('is_walkin', false)->whereDate('started_at', $today)->get()->count(); 
        $total_checked_in['walk_in'] = $bookings->where('is_walkin', true)->whereDate('started_at', $today)->get()->count(); 
    	$total_checked_in['walk_in_group'] = $bookings->where('is_walkin', true)->whereDate('started_at', $today)->get()->count(); 

    	// get the remaining capacity left for today 
    	$capacity_per_day = $user->destination->capacity_per_day;
    	$remaining = $capacity_per_day - $total['guest'];
    	$percentage = ($remaining / $capacity_per_day) * 100;

    	return response()->json([
    		'total' => $total,
    		'percentage' => round($percentage),
    		'remaining' => $remaining,
    		'total_checked_in' => $total_checked_in
    	]);
    }

    public function getBookings() 
    {
        $items = Book::all();
        $data = [];
        foreach ($items as $item) {
            array_push($data, [
                'id' => $item->id,
                'allocation_id' => $item->allocation_id,
                'destination_id' => $item->destination_id,
                'scheduled_at' => Carbon::parse($item->scheduled_at)->toDateString(),
                'started_at' => $item->started_at ?? null,
                'ended_at' => $item->ended_at ?? null,
                'checked_in_at' => $item->checked_in_at,
                're_scheduled_at' => Carbon::parse($item->re_scheduled_at)->toDateString(),
                'status' => $item->status,
                'agency_code' => $item->agency_code,
                'total_guest' => $item->total_guest,
                'payment_type' => $item->payment_type,
                'payment_status' => $item->payment_status,
                'is_walkin' => $item->is_walkin,
                'qr_code_path' => $item->qr_code_path,
                'qr_id' => $item->qr_id,
                'group_remarks' => json_encode($item->groupRemarks),
                'group_violations' => json_encode($item->groupViolations),
                'guests' => json_encode($item->guests),
                'main_contact' => json_encode($item->guests()->where('main', 1)->first()),
                'allocation' => json_encode($item->allocation),
                'created_at' => $item->created_at->format('j M Y h:i A'),
                'is_walkin_label' => $item->is_walkin ? 'Walk-In' : 'Online',
            ]);
        }

        return $data;
    }

    public function getGuests()
    {

        $items = Guest::all();
        $data = [];
        foreach ($items as $item) {
            array_push($data, [
                'id' => $item->id,
                'book_id' => $item->book_id,
                'special_fee_id' => $item->special_fee_id,
                'visitor_type_id' => $item->visitor_type_id,
                'main' => $item->main,
                'first_name' => $item->first_name,
                'gender' => $item->gender,
                'nationality' => $item->nationality,
                'last_name' => $item->last_name,
                'email' => $item->email,
                'birthdate' => $item->birthdate,
                'contact_number' => $item->contact_number,
                'emergency_contact_number' => $item->emergency_contact_number,
                'remarks' => $item->remarks,
                'signature_path' => empty(url($item->renderImagePath('signature_path'))) ? base64_encode(file_get_contents(url($item->renderImagePath('signature_path'))->path())) : null,
            ]);
        }

        return $data;
    }
}
