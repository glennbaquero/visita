<?php

namespace App\Http\Middleware\Admin\Violations;

use App\Extenders\BaseMiddleware as Middleware;

class ViolationMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.violations.crud'];
    }
}
