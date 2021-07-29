<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostView;

class PostViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        PostView::insert([
            [
                'ip' => null,
                'user_id'=> 3,
                'post_id' => 1
            ],
            [
                'ip' => $faker->unique()->ipv4,
                'user_id'=> null,
                'post_id' => 1
            ],
            [
                'ip' => $faker->unique()->ipv4,
                'user_id'=> null,
                'post_id' => 1
            ],
            [
                'ip' => null,
                'user_id'=> 2,
                'post_id' => 1
            ],
            [
                'ip' => null,
                'user_id'=> 4,
                'post_id' => 2
            ],
            [
                'ip' => $faker->ipv4,
                'user_id'=> null,
                'post_id' => 2
            ],
            [
                'ip' => null,
                'user_id'=> 6,
                'post_id' => 3
            ],
            [
                'ip' => null,
                'user_id'=> 4,
                'post_id' => 4
            ],
            [
                'ip' => null,
                'user_id'=> 3,
                'post_id' => 5
            ]
        ]);
    }
}
