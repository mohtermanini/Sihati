<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::insert([
            [
                'name' => 'تمر'
            ],
            [
                'name' => 'حليب'
            ],
            [
                'name' => 'رمضان'
            ],
            [
                'name' => 'أعشاب'
            ],
            [
                'name' => 'الحمل'
            ],
            [
                'name' => 'زيت القرع'
            ],
            [
                'name' => 'فطور'
            ],
            [
                'name' => 'كورونا'
            ],
            [
                'name' => 'لقاح'
            ]
        ]);
    }
}
