<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'email' => 'sihati@gmail.com',
                'password' => bcrypt('123'),
                'user_name' => 'admin',
                'profile_id' => 1,
                'type_id' => 1
            ],
            [
                'email' => 'susan@gmail.com',
                'password' => bcrypt('123'),
                'user_name' => 'susan',
                'profile_id' => 2,
                'type_id' => 2
            ],
            [
                'email' => 'mariam@gmail.com',
                'password' => bcrypt('123'),
                'user_name' => 'mariam_n',
                'profile_id' => 3,
                'type_id' => 3
            ],
            [
                'email' => 'toast@gmail.com',
                'password' => bcrypt('123'),
                'user_name' => 'toast',
                'profile_id' => 4,
                'type_id' => 3
            ],
            [
                'email' => 'secret1111@gmail.com',
                'password' => bcrypt('123'),
                'user_name' => 'sec',
                'profile_id' => 5,
                'type_id' => 3
            ],
            [
                'email' => 'kai@gmail.com',
                'password' => bcrypt('123'),
                'user_name' => 'kai1',
                'profile_id' => 6,
                'type_id' => 3
            ],
            [
                'email' => 'r1fore@gmail.com',
                'password' => bcrypt('123'),
                'user_name' => 'raimon',
                'profile_id' => 7,
                'type_id' => 3
            ],
        ]);
    }
}
