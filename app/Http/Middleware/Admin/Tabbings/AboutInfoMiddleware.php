<?php

namespace App\Http\Middleware\Admin\Tabbings;

use App\Extenders\BaseMiddleware as Middleware;

class AboutInfoMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.about-infos.crud'];
    }
}
