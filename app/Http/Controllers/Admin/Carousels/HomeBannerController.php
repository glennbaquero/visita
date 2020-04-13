<?php

namespace App\Http\Controllers\Admin\Carousels;

use App\Extenders\Controllers\Carousels\HomeBannerController as Controller;

class HomeBannerController extends Controller
{
    protected $indexView = 'admin.home-banners.index';
    protected $createView = 'admin.home-banners.create';
    protected $showView = 'admin.home-banners.show';

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Carousels\HomeBannerMiddleware', 
            ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        );
    }
}
