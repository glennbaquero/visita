<?php

namespace App\Http\Middleware\Admin\SurveyExperiences;

use App\Extenders\BaseMiddleware as Middleware;

class SurveyExperienceMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.survey_experiences.crud'];
    }
}
