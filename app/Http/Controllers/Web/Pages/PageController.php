<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

use App\Models\Pages\Page;

class PageController extends Controller
{

	/* Show Stylesheet */
	public function showStylesheet() {
        return view('web.pages.stylesheet', [

        ]);
	}

	/* Show Home */
	public function showHome() {
        $data = $this->getPageData('home');
        
        return view('web.pages.home', array_merge($data, [
        	'quote' => Inspiring::quote(),
        ]));
	}

	/* Get Page Data */
	protected function getPageData($slug) {
		$item = Page::where('slug', $slug)->firstOrFail();
		return $item->getData();
	}
}
