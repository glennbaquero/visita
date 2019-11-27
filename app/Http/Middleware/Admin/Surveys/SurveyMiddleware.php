<?php

namespace App\Http\Middleware\Admin\Surveys;

use App\Extenders\BaseMiddleware as Middleware;

class SurveyMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.surveys.crud'];
    }
}
