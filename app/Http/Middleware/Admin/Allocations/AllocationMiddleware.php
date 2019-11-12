<?php

namespace App\Http\Middleware\Admin\Allocations;

use App\Extenders\BaseMiddleware as Middleware;

class AllocationMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.allocations.crud'];
    }
}
