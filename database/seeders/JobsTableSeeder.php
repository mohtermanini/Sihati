<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;


class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::insert([
            [
                'title' => 'جراحة الكلى والمسالك البولية والذكورة والعقم'
            ],
            [
                'title' => 'طب أطفال'
            ],
            [
                'title' => 'جراحة قلب'
            ],
            [
                'title' => 'طب عام'
            ],
            [
                'title' => 'أذن أنف حنجرة'
            ],
            [
                'title' => 'طبيب جلدية'
            ],
            [
                'title' => 'طبيب عيون'
            ],
            [
                'title' => 'جراحة قرنية'
            ]
        ]);
    }
}
