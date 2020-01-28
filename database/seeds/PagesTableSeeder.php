<?php

use Illuminate\Database\Seeder;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Imports\Pages\PageImport;
use App\Imports\Pages\PageItemImport;

use App\Imports\Carousels\HomeBannerImport;

use App\Imports\Tabbings\AboutInfoImport;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::beginTransaction();

        Excel::import(new PageImport, storage_path('imports/pages.xls'));
        Excel::import(new PageItemImport, storage_path('imports/page-items.xls'));
        Excel::import(new HomeBannerImport, storage_path('imports/home_banners.xls'));
        Excel::import(new AboutInfoImport, storage_path('imports/about_infos.xls'));

        DB::commit();
    }
}
