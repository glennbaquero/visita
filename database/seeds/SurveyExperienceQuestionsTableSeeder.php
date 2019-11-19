<?php

use Illuminate\Database\Seeder;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Imports\SurveyExperiences\SurveyExperienceQuestionImport;

class SurveyExperienceQuestionsTableSeeder extends Seeder
{
      /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::beginTransaction();

        Excel::import(new SurveyExperienceQuestionImport, storage_path('imports/survey_experience_questions.xls'));

        DB::commit();
    }
}
