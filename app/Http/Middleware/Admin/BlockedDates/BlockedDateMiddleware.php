<?php

namespace App\Http\Middleware\Admin\BlockedDates;

use App\Extenders\BaseMiddleware as Middleware;

class BlockedDateMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.blocked-dates.crud'];
    }
}
