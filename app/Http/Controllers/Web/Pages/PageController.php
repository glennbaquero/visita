<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

use App\Models\Pages\Page;
use App\Models\Carousels\HomeBanner;
use App\Models\Tabbings\AboutInfo;

class PageController extends Controller
{

	/* Show Stylesheet */
	public function showStylesheet() {
        return view('web.pages.stylesheet', [

        ]);
	}

	/* Show Home */
	public function showHome() {
		$page = Page::where('slug', 'home')->first();
		$home_banners = HomeBanner::all();
		$about_infos = AboutInfo::all();

        $data = $page->getData();
        return view('web.pages.home', [ 
        	'data' => $data, 
        	'home_banners' => $home_banners, 
        	'about_infos' => $about_infos, 
        ]);
	}

	/* Get Page Data */
	protected function getPageData($slug) {
		$item = Page::where('slug', $slug)->firstOrFail();
		return $item->getData();
	}
}
