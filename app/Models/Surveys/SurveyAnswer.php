<?php

namespace App\Models\Surveys;

use App\Extenders\Models\BaseModel as Model;

class SurveyAnswer extends Model
{

	protected $casts = [
		'survey_experience_data' => 'array'
	];
	
    public function survey()
    {
    	return $this->belongsTo(Survey::class)->withTrashed();
    }
}
