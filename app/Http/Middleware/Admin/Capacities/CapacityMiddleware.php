<?php

namespace App\Http\Middleware\Admin\Capacities;

use App\Extenders\BaseMiddleware as Middleware;

class CapacityMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.capacities.crud'];
    }
}
