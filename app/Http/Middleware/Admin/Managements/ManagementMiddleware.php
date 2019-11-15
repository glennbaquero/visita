<?php

namespace App\Http\Middleware\Admin\Managements;

use App\Extenders\BaseMiddleware as Middleware;

class ManagementMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.managements.crud'];
    }
}
