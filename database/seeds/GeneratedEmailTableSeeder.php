<?php

use Illuminate\Database\Seeder;

use App\Models\Emails\GeneratedEmail;

class GeneratedEmailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row = 0;
        
        if(($handle = fopen('database/csv/generated_emails.csv', "r")) !== FALSE){
        	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $this->command->info('writing row ' . $row . ' ' . $data[0]);

                $item = new GeneratedEmail();
                $item->notification_type = $data[0];
                $item->title = $data[1];
                $item->message = $data[2];
                $item->deleted_at = $data[3];
                $item->created_at = $data[4];
                $item->updated_at = $data[5];

                $item->save();

                $row++;

            }
            fclose($handle);
        }
    }
}
