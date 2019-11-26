<?php

namespace App\Imports\Faqs;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Faqs\Faq;


class FaqImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
    		Faq::updateOrCreate([
    			'question' => $row['question'],
    		], [
	            'question' => $row['question'],
	            'answer' => $row['answer'],
	            'type' => $row['type'],
    		]);
    	}
    }
}
