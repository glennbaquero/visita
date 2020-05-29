<?php

namespace App\Http\Middleware\Admin\CivilStatus;

use App\Extenders\BaseMiddleware as Middleware;

class CivilStatusMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.civil_statuses.crud'];
    }
}
