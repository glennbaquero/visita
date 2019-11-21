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
use App\Models\Faqs\Faq;
use App\Models\Remarks\Remark;
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
    	$checked_in_walkin['visitors'] = $bookings->where('is_walkin', true)->whereDate('checked_in_at', $today)->get()->count(); 
    	$checked_in_walkin['groups'] = $bookings->where('is_walkin', true)->whereDate('checked_in_at', $today)->get()->count(); 

    	// get total checked in for online in guest
        $total_checked_in['online_visitor'] = $bookings->where('is_walkin', false)->whereDate('checked_in_at', $today)->get()->count(); 
        $total_checked_in['online_group'] = $bookings->where('is_walkin', false)->where('is_walkin', false)->whereDate('checked_in_at', $today)->get()->count(); 
        $total_checked_in['walk_in'] = $bookings->where('is_walkin', true)->whereDate('checked_in_at', $today)->get()->count(); 
    	$total_checked_in['walk_in_group'] = $bookings->where('is_walkin', true)->where('is_walkin', false)->whereDate('checked_in_at', $today)->get()->count(); 

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
}
