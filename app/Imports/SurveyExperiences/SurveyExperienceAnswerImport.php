<?php

namespace App\Imports\SurveyExperiences;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Answers\Answer;

class SurveyExperienceAnswerImport implements ToCollection, WithHeadingRow
{
     public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
    		Answer::updateOrCreate([
    			'id' => $row['id'],
    		], [
                'answerable_id' => $row['answerable_id'],
                'answerable_type' => $row['answerable_type'],
	            'answer' => $row['answer'],
	            'type' => $row['type'],
    		]);
    	}
    }
}
