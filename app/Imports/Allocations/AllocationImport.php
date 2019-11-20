<?php

namespace App\Imports\Allocations;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Allocations\Allocation;

class AllocationImport implements ToCollection, WithHeadingRow
{
   public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
    		Allocation::updateOrCreate([
    			'name' => $row['name'],
    		], [
	            'destination_id' => $row['destination_id'],
	            'description' => $row['description'],
    		]);
    	}
    }
}

