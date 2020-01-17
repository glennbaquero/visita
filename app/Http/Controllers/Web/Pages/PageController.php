<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

use App\Models\Pages\Page;
use App\Models\Faqs\Faq;
use App\Models\Pages\AboutUs;
use App\Models\Pages\AboutUsFrameThree;
use App\Models\Pages\Team;
use App\Models\Carousels\HomeBanner;
use App\Models\Tabbings\AboutInfo;


use App\Models\Destinations\Destination;
use App\Models\Types\VisitorType;
use App\Models\Genders\Gender;
use Webpatser\Countries\Countries;

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
		
		$page = Page::where('slug', 'home')->first();
		$home_banners = HomeBanner::all();
		$about_infos = AboutInfo::all();

        $data = $page->getData();
        $destination = $this->formatData();

        // $destinations = Destination::all();

        return view('web.pages.home', [ 
        	'data' => $data, 
        	'home_banners' => $home_banners, 
        	'about_infos' => $about_infos, 
        	'destination' => json_encode($destination),
        	'page_scripts'=> 'home'
        ]);
	}

	/* 
	* Show About Us 
	*/
	public function showAboutUs() {
		$content = AboutUs::latest()->first();
		$content['image_url'] = $content->renderImagePath();

		$teams = $this->getFrameTwoContent(Team::where('type', 0)->get());
		$collaborators = $this->getFrameTwoContent(Team::where('type', 1)->get());
		$advisors = $this->getFrameTwoContent(Team::where('type', 2)->get());

		$frame_threes = $this->getFrameThreeContent(AboutUsFrameThree::all());

        return view('web.pages.about-us', [
        	'page_scripts'=> 'about',
        	'content' => $content,
        	'teams' => $teams,
        	'collaborators' => $collaborators,
        	'advisors' => $advisors,
        	'frame_threes' => $frame_threes,
        ]);
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
		$result = [];
        $destinations = Destination::with('experiences')->get();
        foreach ($destinations as $key => $destination) {
        	array_push($result, [
        		'destination' => $destination,
        		'id' => $destination->id,
        		'name' => $destination->name,
        		'short_description' => str_limit($destination->overview, 70),
        		'capacity' => $destination->capacity,
        		'image' => $destination->pictures->first()->renderImagePath(),
        		'requestVisitUrl' => $destination->renderRequestVisitUrl()
        	]);
        }
        return view('web.pages.destination.destinations', [
        	'page_scripts'=> 'destinations',
        	'destinations' => $result
        ]);
	}

	public function showDestinationsInfo() {
        return view('web.pages.destination.destinations-info', [
        	'page_scripts'=> 'destinations'
        ]);
	}

	public function showRequestToVisit($id, $name) {
		$destination = Destination::find($id);
		$destination->image = $destination->pictures->first()->renderImagePath();
		$destination->allocations = $destination->allocations;
		$destination->dateBlock = $destination->getBlockedDates();
		$result = $destination->getFormattedData();
		$visitor_types = VisitorType::all();
		$genders = Gender::all();
		$countries = Countries::all();
        return view('web.pages.destination.request-to-visit', [
        	'page_scripts'=> 'requestToVisit',
        	'destination' => $destination,
        	'visitor_types' => $visitor_types,
        	'genders' => $genders,
        	'countries' => $countries,
        	'items' => json_encode($result),
        ]);
	}

	/* 
	* Show Faqs 
	*/
	public function showFaqs() {
		$visitors = Faq::where('type', 'VISITOR')->get();
		$managers = Faq::where('type', 'DESTINATION MANAGER')->get();
        return view('web.pages.faqs', [
        	'page_scripts'=> 'faqs',
        	'visitors'=> $visitors,
        	'managers'=> $managers
        ]);
	}

	/* 
	* Show Contact Us 
	*/
	public function showContactUs() {
		$page = Page::where('slug', 'home')->first();

        $data = $page->getData();
        $destination = $this->formatData();

        return view('web.pages.contact-us', [
        	'data' => $data,
        	'page_scripts'=> 'contact-us'
        ]);
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

        return view('web.pages.auth.sign-up', [
        	'page_scripts'=> 'sign-up'
        ]);
	}

	public function showForgotPassword() {

        return view('web.pages.auth.forgot-password', [
        	'page_scripts'=> 'forgot-password'
        ]);
	}

	public function showResetPassword() {

        return view('web.pages.auth.reset-password', [
        	'page_scripts'=> 'reset-password'
        ]);
	}

	/* 
	* Show Dashboard, Profile
	*/
	public function showDashboard() {

        return view('web.pages.user.dashboard', [
        	'page_scripts'=> 'dashboard'
        ]);
	}

	public function showProfile() {

        return view('web.pages.user.profile', [
        	'page_scripts'=> 'profile'
        ]);
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
}
