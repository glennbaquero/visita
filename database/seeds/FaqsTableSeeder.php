<?php

use Illuminate\Database\Seeder;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Imports\Faqs\FaqImport;

class FaqsTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::beginTransaction();

        Excel::import(new FaqImport, storage_path('imports/faqs.xls'));

        DB::commit();
    }
}
