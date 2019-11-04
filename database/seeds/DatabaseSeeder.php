<?php

use Illuminate\Database\Seeder;

use App\Seeders\AdminsTableSeeder;
use App\Seeders\PermissionsTableSeeder;
use App\Seeders\RolesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
    }
}
