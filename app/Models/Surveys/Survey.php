<?php

namespace App\Models\Surveys;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Books\Book;

class Survey extends Model
{
    public function book()
    {
    	return $this->belongsTo(Book::class);
    }

    public function surveyExperienceAnswers()
    {
    	return $this->hasMany(SurveyAnswer::class);
    }
}
