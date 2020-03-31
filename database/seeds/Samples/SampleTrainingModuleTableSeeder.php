<?php

use Illuminate\Database\Seeder;

use App\Models\TrainingModules\TrainingModule;

class SampleTrainingModuleTableSeeder extends Seeder
{
  /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TrainingModule::class, 4)->create();
    }
}
