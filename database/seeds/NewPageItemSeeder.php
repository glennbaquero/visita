<?php

use Illuminate\Database\Seeder;

use App\Models\Pages\PageItem;

class NewPageItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row = 0;
        
        if(($handle = fopen('database/csv/new_page_items.csv', "r")) !== FALSE){
        	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $this->command->info('writing row ' . $row . ' ' . $data[0]);

                $item = new PageItem();
                $item->page_id = $data[0];
                $item->name = $data[1];
                $item->slug = $data[2];
                $item->content = $data[3];
                $item->type = $data[4];
                $item->created_at = $data[5];
                $item->updated_at = $data[6];

                $item->save();

                $row++;

            }
            fclose($handle);
        }
    }
}
