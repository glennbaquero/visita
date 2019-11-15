<?php

namespace App\Http\Middleware\Admin\Calendars;

use App\Extenders\BaseMiddleware as Middleware;

class CalendarMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.calendar.crud'];
    }
}
