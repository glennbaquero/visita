<?php

namespace App\Http\Middleware\Admin\Agencies;

use App\Extenders\BaseMiddleware as Middleware;

class AgencyMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.agencies.crud'];
    }
}
