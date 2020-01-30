<?php

use Illuminate\Database\Seeder;

class SampleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $this->call(AdminsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);

        $this->call(PagesTableSeeder::class);
        $this->call(CountriesSeeder::class);

        $this->call(SampleItemsTableSeeder::class);
        $this->call(SampleItemRelationshipsTableSeeder::class);
        $this->call(SampleArticlesTableSeeder::class);
        $this->call(SampleAdminsTableSeeder::class);
        $this->call(SampleUsersTableSeeder::class);
         $this->call(SampleTrainingModuleTableSeeder::class);

        $this->call(DestinationsTableSeeder::class);
        $this->call(ExperiencesTableSeeder::class);
        $this->call(AllocationsTableSeeder::class);
        $this->call(AnnualIncomesTableSeeder::class);
        $this->call(FeedbackQuestionsTableSeeder::class);
        $this->call(FeedbackAnswersTableSeeder::class);
        $this->call(SurveyExperienceQuestionsTableSeeder::class);
        $this->call(SurveyExperienceAnswersTableSeeder::class);
        $this->call(FaqsTableSeeder::class);

        $this->call(NewPageItemSeeder::class);

    }
}
