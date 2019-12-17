<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

use App\Models\Pages\Page;
use App\Models\Carousels\HomeBanner;
use App\Models\Tabbings\AboutInfo;

use App\Models\Destinations\Destination;

class PageController extends Controller
{

	/* Show Stylesheet */
	public function showStylesheet() {
        return view('web.pages.stylesheet', [

        ]);
	}

	/* Show Privacy Policy */
	public function showPrivacyPolicy() {

		$page = Page::where('slug', 'privacy_policy')->first();
		$data = $page->getData();
		
        return view('web.pages.privacy-policy', [
        	'data' => $data,
        ]);
	}

	/* Show Home */
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

	/* Show About Us */
	public function showAboutUs() {
        return view('web.pages.about-us', [
        	'page_scripts'=> 'about'
        ]);
	}

	/* Show Destinations */
	public function showDestinations() {
        return view('web.pages.destination.destinations', [
        	'page_scripts'=> 'destinations'
        ]);
	}

	/* Show Destinations Info */
	public function showDestinationsInfo() {
        return view('web.pages.destination.destinations-info', [
        	'page_scripts'=> 'destinations'
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
