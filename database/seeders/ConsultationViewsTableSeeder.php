<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConsultationView;

class ConsultationViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        ConsultationView::insert([
            [
                'ip' => null,
                'user_id'=> 2,
                'consultation_id' => 1
            ],
            [
                'ip' => $faker->unique()->ipv4,
                'user_id'=> null,
                'consultation_id' => 1
            ],
            [
                'ip' => $faker->unique()->ipv4,
                'user_id'=> null,
                'consultation_id' => 1
            ],
            [
                'ip' => null,
                'user_id'=> 3,
                'consultation_id' => 1
            ],
            [
                'ip' => null,
                'user_id'=> 2,
                'consultation_id' => 2
            ],
            [
                'ip' => null,
                'user_id'=> 3,
                'consultation_id' => 2
            ],
            [
                'ip' => null,
                'user_id'=> 3,
                'consultation_id' => 3
            ],
            [
                'ip' => null,
                'user_id'=> 2,
                'consultation_id' => 3
            ],
            [
                'ip' => null,
                'user_id'=> 3,
                'consultation_id' => 4
            ],
            [
                'ip' => null,
                'user_id'=> 5,
                'consultation_id' => 4
            ],
            [
                'ip' => null,
                'user_id'=> 6,
                'consultation_id' => 4
            ],
            [
                'ip' => $faker->unique()->ipv4,
                'user_id'=> null,
                'consultation_id' => 4
            ]
        ]);
    }
}
