<?php

use Illuminate\Database\Seeder;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Imports\Feedbacks\FeedbackAnswerImport;

class FeedbackAnswersTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::beginTransaction();

        Excel::import(new FeedbackAnswerImport, storage_path('imports/feedbacks_answer.xls'));

        DB::commit();
    }
}
