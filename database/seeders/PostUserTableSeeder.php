<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostUser;

class PostUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostUser::insert([
            [
                'post_id' => 1,
                'user_id' => 3
            ],
            [
                'post_id' => 2,
                'user_id' => 4
            ],
            [
                'post_id' => 2,
                'user_id' => 5
            ],
            [
                'post_id' => 3,
                'user_id' => 4
            ],
            [
                'post_id' => 3,
                'user_id' => 7
            ],
            [
                'post_id' => 3,
                'user_id' => 6
            ],
            [
                'post_id' => 4,
                'user_id' => 4
            ],
            [
                'post_id' => 5,
                'user_id' => 4
            ],
            [
                'post_id' => 5,
                'user_id' => 3
            ],
            [
                'post_id' => 6,
                'user_id' => 3
            ],
            [
                'post_id' => 6,
                'user_id' => 7
            ]
        ]);
    }
}
