<?php

namespace App\Models\Feedbacks;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Answers\Answer;

class Feedback extends Model
{
    public function answers()
    {
    	return $this->morphMany(Answer::class, 'answerable');
    }
}
