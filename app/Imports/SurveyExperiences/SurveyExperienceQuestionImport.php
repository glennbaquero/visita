<?php

namespace App\Imports\SurveyExperiences;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Surveys\SurveyExperience;

class SurveyExperienceQuestionImport implements ToCollection, WithHeadingRow
{
     public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
    		SurveyExperience::updateOrCreate([
    			'question' => $row['question'],
    		], [
	            'answerable' => $row['answerable'],
	            'others_placeholder' => $row['others_placeholder'],
 	            'show_other' => $row['show_other'],
    		]);
    	}
    }
}
