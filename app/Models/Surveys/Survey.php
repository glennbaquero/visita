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


    /**
     * @Render
     */

     public function renderName() {
        return $this->book->guests->first()->first_name . ' ' . $this->book->guests->first()->last_name . ' ' . 'Group';
    }

    public function renderShowUrl($prefix = 'admin') {
        $route = $this->id;

        if ($prefix == 'web') {
            $route = [$this->id, $this->slug];
        }

        return route($prefix . '.surveys.show', $route);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.surveys.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.surveys.restore', $this->id);
    }
}
