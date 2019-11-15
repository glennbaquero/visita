<?php

namespace App\Http\Middleware\Admin\Religions;

use App\Extenders\BaseMiddleware as Middleware;

class ReligionMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.religions.crud'];
    }
}
