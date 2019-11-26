<?php

namespace App\Imports\Experiences;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Experiences\Experience;

class ExperienceImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
    		Experience::updateOrCreate([
    			'name' => $row['name'],
    		], [
	            'destination_id' => $row['destination_id'],
	            'description' => $row['description'],
	            'fee' => $row['fee'],
    		]);
    	}
    }
}

