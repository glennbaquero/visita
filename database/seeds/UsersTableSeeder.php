<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Helpers\SeederHelpers;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    protected $users;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'first_name' => 'Web',
                'last_name' => 'User',
                'image_path' => SeederHelpers::randomFile(),
                'email' => 'user@app.com',
                'password' => 'password',
                'username' => 'webapp'
            ],
        ];

        foreach($items as $item) {
            User::create([
                'first_name' => $item['first_name'],
                'last_name' => $item['last_name'],
                'image_path' => $item['image_path'],
                'email' => $item['email'],
                'password' => Hash::make($item['password']),
                'email_verified_at' => now(),
            ]);
        }
    }
}
