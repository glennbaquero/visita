<?php

namespace App\Models\Surveys;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Books\Book;

class Survey extends Model
{

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $searchable = [
            'id' => $this->id,
            'name' => $this->book ? $this->renderName() : '',
        ];
        
        return $searchable;
    }

    public function book()
    {
    	return $this->belongsTo(Book::class)->withTrashed();
    }

    public function surveyExperienceAnswers()
    {
    	return $this->hasMany(SurveyAnswer::class);
    }


    /**
     * @Render
     */

     public function renderName() {
        return $this->book->guests->where('main', true)->first()->first_name . ' ' . $this->book->guests->where('main', true)->first()->last_name . ' ' . 'Group';
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
