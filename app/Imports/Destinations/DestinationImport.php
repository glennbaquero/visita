<?php

namespace App\Imports\Destinations;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Destinations\Destination;

class DestinationImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
    		Destination::updateOrCreate([
    			'name' => $row['name'],
    		], [
	            'icon' => $row['icon'],
	            'terms_conditions' => $row['terms_conditions'],
	            'visitor_policies' => $row['visitor_policies'],
	            'operating_hours' => $row['operating_hours'],
	            'orientation_module' => $row['orientation_module'],
	            'capacity_per_day' => $row['capacity_per_day'],
	            'overview' => $row['overview'],
	            'contact_us' => $row['contact_us'],
	            'fees' => $row['fees'],
	            'how_to_get_here' => $row['how_to_get_here'],
    		]);
    	}
    }
}

