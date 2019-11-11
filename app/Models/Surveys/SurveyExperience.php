<?php

namespace App\Models\Surveys;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Answers\Answer;

class SurveyExperience extends Model
{
    
    public function answers()
    {
    	return $this->morphMany(Answer::class, 'answerable');
    }

}
