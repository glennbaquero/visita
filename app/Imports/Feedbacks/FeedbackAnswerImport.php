<?php

namespace App\Imports\Feedbacks;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Answers\Answer;

class FeedbackAnswerImport implements ToCollection, WithHeadingRow
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

