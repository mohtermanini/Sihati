<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobProfile;

class JobProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobProfile::insert([
            [
                'job_id' => 4,
                'profile_id' => 2
            ],
            [
                'job_id' => 2,
                'profile_id' => 3
            ],
            [
                'job_id' => 3,
                'profile_id' => 3
            ],
            [
                'job_id' => 1,
                'profile_id' => 4
            ],
            [
                'job_id' => 5,
                'profile_id' => 5
            ],
            [
                'job_id' => 6,
                'profile_id' => 6
            ],
            [
                'job_id' => 7,
                'profile_id' => 7
            ],
            [
                'job_id' => 8,
                'profile_id' => 7
            ]

        ]);
    }
}
