<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

use App\Models\Pages\Page;
use App\Models\Pages\PageItem;
use App\Models\Faqs\Faq;
use App\Models\Pages\AboutUs;
use App\Models\Pages\AboutUsFrameThree;
use App\Models\Pages\Team;
use App\Models\Allocations\Allocation;
use App\Models\Books\Book;
use App\Models\Carousels\HomeBanner;
use App\Models\Tabbings\AboutInfo;


use App\Models\Destinations\Destination;
use App\Models\Types\VisitorType;
use App\Models\Genders\Gender;
use Webpatser\Countries\Countries;

use Carbon\Carbon;

class PageController extends Controller
{

	/* 
	* Show Stylesheet 
	*/
	public function showStylesheet() {
        return view('web.pages.stylesheet', [

        ]);
	}

	/* 
	* Show Home 
	*/
	public function showHome() {

        $data = $this->getPageData('home');
    	$destination = $this->formatData();
        $twitter = PageItem::where('slug', 'twitter')->first();
        $fb = PageItem::where('slug', 'facebook')->first();
        $insta = PageItem::where('slug', 'instagram')->first();
        $youtube = PageItem::where('slug', 'youtube')->first();
        
        return view('web.pages.home', array_merge($data, [
        	'quote' => Inspiring::quote(),
        	'home_banners' => HomeBanner::all(),
        	'about_infos' => AboutInfo::all(),
        	'destination' => json_encode($destination),
        	'page_scripts'=> 'home',
        	'fb' => $fb,
        	'twitter' => $twitter,
        	'insta' => $insta,
        	'youtube' => $youtube,
        ]));

	}

	/* 
	* Show About Us 
	*/
	public function showAboutUs() {

        $data = $this->getPageData('about');
        
        $teams = $this->getFrameTwoContent(Team::where('type', 0)->get());
        $collaborators = $this->getFrameTwoContent(Team::where('type', 1)->get());
        $advisors = $this->getFrameTwoContent(Team::where('type', 2)->get());

        $frame_threes = $this->getFrameThreeContent(AboutUsFrameThree::all());

        return view('web.pages.about-us', array_merge($data, [
        	'quote' => Inspiring::quote(),
        	'teams' => $teams,
        	'collaborators' => $collaborators,
        	'advisors' => $advisors,
        	'frame_threes' => $frame_threes,
        	'page_scripts'=> 'about'
        ]));
        
	}

	public function getFrameTwoContent($datas) {
		$result = [];
		foreach ($datas as $data) {
			array_push($result, [
				'name' => $data->name,
				'role' => $data->renderTypeLabel(),
				'description' => $data->description,
				'image_path' => $data->renderImagePath()
			]);
		}

		return $result;
	}

	public function getFrameThreeContent($datas) {
		$result = [];
		foreach ($datas as $data) {
			array_push($result, [
				'title' => $data->title,
				'description' => $data->description,
				'image_path' => $data->renderImagePath()
			]);
		}

		return $result;
	}

	/* 
	* Show Destinations, Destinations Info and Request A Visit 
	*/
	public function showDestinations() {

        $data = $this->getPageData('destination');

		$result = [];
        $destinations = Destination::with('experiences')->get();
        $destination_info = Destination::orderBy('id', 'ASC')->get();

        foreach ($destinations as $key => $destination) {
        	array_push($result, [
        		'destination' => $destination,
        		'destination_info' => $destination_info,
        		'id' => $destination->id,
        		'name' => $destination->name,
        		'short_description' => str_limit($destination->overview, 70),
        		'capacity' => $destination->capacity,
        		'image' => $destination->pictures->first()->renderImagePath(),
        		'is_available' => $destination->is_available,
        		'requestVisitUrl' => $destination->renderRequestVisitUrl(),
        		'viewDestinationUrl' => $destination->renderViewDestinationUrl(),
        	]);
        }
        
        return view('web.pages.destination.destinations', array_merge($data, [
        	'destinations' => $result,
        	'page_scripts'=> 'destinations'
        ]));
	}

	public function showDestinationsInfo($id) {
        $data = $this->getPageData('destination');
        $selected_destination = Destination::with('allocations')->find($id);
        $selected_destination['request_url'] = $selected_destination->renderRequestVisitUrl();
        $selected_destination['is_available_for_request'] = $selected_destination->is_available ? true : false;
        
        return view('web.pages.destination.destinations-info', array_merge($data, [
        	'quote' => Inspiring::quote(),
        	'selected_destination' => $selected_destination,
        ]));

	}

	public function showRequestToVisit($id, $name) {
		$destination = Destination::find($id);
        $data = $this->getPageData('destination');
        $totalReserved = Book::where('destination_id', $id)->sum('total_guest');
        $totalReservation = $destination->capacity_per_day;

        $destination->totalReserved = $totalReserved;
        $destination->totalReservation = $totalReservation;
        $destination->availableSeat = $totalReservation - $totalReserved;

		if(!auth()->guard('web')->check()) {
	       	session(['destination' => $destination]);
	       	return redirect()->route('web.login');
		}

		$destination->image = $destination->pictures->first()->renderImagePath();
		$destination->dateBlock = $destination->getBlockedDates();
		$result = $destination->getFormattedData();
		$visitor_types = VisitorType::all();
		$genders = Gender::all();
		$countries = Countries::orderBy('citizenship', 'asc')->get();

		$info['conservation_fee_info'] = PageItem::where('slug', 'conservation_fee_info')->first() ? PageItem::where('slug', 'conservation_fee_info')->first()->content : null;
		$info['platform_fee_info'] = PageItem::where('slug', 'platform_fee_info')->first() ? PageItem::where('slug', 'platform_fee_info')->first()->content : null;
		$info['transaction_fee_info'] = PageItem::where('slug', 'transaction_fee_info')->first() ? PageItem::where('slug', 'transaction_fee_info')->first()->content : null;

        
        return view('web.pages.destination.request-to-visit', array_merge($data, [
        	'quote' => Inspiring::quote(),
           	'destination' => $destination,
        	'visitor_types' => $visitor_types,
        	'genders' => $genders,
        	'countries' => $countries,
        	'items' => json_encode($result),
        	'page_scripts'=> 'requestToVisit',
			'info' => json_encode($info)       	
        ]));

	}

	/* 
	* Show Faqs 
	*/
	public function showFaqs() {

        $data = $this->getPageData('faqs');
		$visitors = Faq::where('type', 'VISITOR')->get();
		$managers = Faq::where('type', 'DESTINATION MANAGER')->get();
        // dd($data);
        return view('web.pages.faqs', array_merge($data, [
        	'quote' => Inspiring::quote(),
        	'visitors'=> $visitors,
        	'managers'=> $managers,
        	'page_scripts'=> 'faqs'
        ]));
	}

	/* 
	* Show Contact Us 
	*/
	public function showContactUs() {

        $data = $this->getPageData('contact_us');
        $twitter = PageItem::where('slug', 'twitter')->first();
        $fb = PageItem::where('slug', 'facebook')->first();
        $insta = PageItem::where('slug', 'instagram')->first();
        $youtube = PageItem::where('slug', 'youtube')->first();
        
        return view('web.pages.contact-us', array_merge($data, [
        	'quote' => Inspiring::quote(),
        	'page_scripts'=> 'contact-us',
        	'twitter' => $twitter,
        	'fb' => $fb,
        	'insta' => $insta,
        	'youtube' => $youtube,
        ]));

	}

	/* 
	* Show Login, Sign Up, Forgot Password and Reset Password
	*/
	public function showLogin() {
        return view('web.pages.auth.login', [
        	'page_scripts'=> 'login'
        ]);
	}

	public function showSignUp() {

        $data = $this->getPageData('login');
        
        return view('web.pages.auth.sign-up', array_merge($data, [
        	'quote' => Inspiring::quote(),
        	'page_scripts'=> 'sign-up'
        ]));

	}

	public function showForgotPassword() {

        $data = $this->getPageData('login');
        
        return view('web.pages.auth.forgot-password', array_merge($data, [
        	'quote' => Inspiring::quote(),
        	'page_scripts'=> 'forgot-password'
        ]));

	}

	public function showResetPassword() {

        $data = $this->getPageData('login');
        
        return view('web.pages.auth.reset-password', array_merge($data, [
        	'quote' => Inspiring::quote(),
        	'page_scripts'=> 'reset-password'
        ]));
   
	}

	/* 
	* Show Dashboard, Profile
	*/
	public function showDashboard() {

        $data = $this->getPageData('dashboard');
        
        return view('web.pages.user.dashboard', array_merge($data, [
        	'quote' => Inspiring::quote(),
        	'page_scripts'=> 'dashboard'
        ]));

	}

	public function showProfile() {

        $data = $this->getPageData('profile');
        
        return view('web.pages.user.profile', array_merge($data, [
        	'quote' => Inspiring::quote(),
        	'page_scripts'=> 'profile'
        ]));

	}

	/* 
	* Show Privacy Policy 
	*/
	public function showPrivacyPolicy() {

		$page = Page::where('slug', 'privacy_policy')->first();
		$data = $page->getData();
		
        return view('web.pages.privacy-policy', [
        	'data' => $data,
        ]);
	}

	public function formatData() {
		$result = [];

		$destinations = Destination::all();

		foreach ($destinations as $destination) {
			array_push($result, [
				'destination' => $destination,
				'experiences' => $destination->experiences,
				'picture' => $destination->pictures()->first()->renderImagePath()
			]);
		}

		return $result;
	}

	public function fetchDestination() {

        $destinations = Destination::all();
        return response()->json([
        	'destinations' => $destinations
        ]);
	}
	/* Get Page Data */
	protected function getPageData($slug) {
		$item = Page::where('slug', $slug)->firstOrFail();
		return $item->getData();
	}

	public function frontlinerSuccessPage() {
		return view('web.pages.management.password-reset-success');
	}

	public function getTimeSlot(Request $request) {
		$allocation = Allocation::find($request->allocationSelected);
		$reserveds = Book::where(['allocation_id' => $allocation->id])->get();
		$total_reservation = $allocation->capacities->first() ? $allocation->capacities->first()->online : null;
		if($total_reservation < $allocation->destination->capacity_per_day) {
			$total_reservation = $allocation->destination->capacity_per_day;
		}
		$result = [];

		foreach ($reserveds as $reserved) {
			$is_reserved = $reserveds->where('scheduled_at', $reserved->scheduled_at)->count();
			if($is_reserved >= $total_reservation) {
				array_push($result, [
					Carbon::parse($reserved->scheduled_at)->format('Y-m-d')
				]);
			}
		}

		return collect($result)->flatten();
		
	}

	public function showPolicies($type) {
		$page = Page::where('slug', $type)->first() ?? 'We still working on it!';
		$data = $page->getData();

		return view('web.pages.privacy-policy', [
			'data' => $data
		]);
	}
}
