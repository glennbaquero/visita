<?php

namespace App\Http\Middleware\Admin\Destinations;

use App\Extenders\BaseMiddleware as Middleware;

class DestinationMiddleware  extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.destinations.crud'];
    }
}
