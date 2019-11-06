<?php

namespace App\Http\Controllers\Admin\Tabbings;

use App\Extenders\Controllers\Tabbings\AboutInfoController as Controller;

class AboutInfoController extends Controller
{
    protected $indexView = 'admin.about-infos.index';
    protected $createView = 'admin.about-infos.create';
    protected $showView = 'admin.about-infos.show';

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Tabbings\AboutInfoMiddleware', 
            ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        );
    }
}
