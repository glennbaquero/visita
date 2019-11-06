<?php

namespace App\Http\Middleware\Admin\Carousels;

use App\Extenders\BaseMiddleware as Middleware;

class HomeBannerMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.home-banners.crud'];
    }
}
