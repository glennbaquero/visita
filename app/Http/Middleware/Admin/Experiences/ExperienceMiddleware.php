<?php

namespace App\Http\Middleware\Admin\Experiences;

use App\Extenders\BaseMiddleware as Middleware;

class ExperienceMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.experiences.crud'];
    }
}
