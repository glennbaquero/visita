<?php

namespace App\Imports\Feedbacks;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Feedbacks\Feedback;

class FeedbackQuestionImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
    		Feedback::updateOrCreate([
    			'question' => $row['question'],
    		], [
	            'answerable' => $row['answerable'],
                'others_placeholder' => $row['others_placeholder'],
	            'show_other' => $row['show_other'],
    		]);
    	}
    }
}
