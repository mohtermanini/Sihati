<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostCategory;
use \App\Http\Controllers\GeneralController;

class PostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostCategory::insert([
            [
            'name' => 'العظام',
            'slug' => GeneralController::make_slug('العظام'),
            'img' => 'files/post_categories/العظام.jpg'
            ],
            [
            'name' => 'الرياضة',
            'slug' => GeneralController::make_slug('الرياضة'),
            'img' => 'files/post_categories/الرياضة.jpg'
            ],
            [
            'name' => 'الأدوية والمستحضرات الطبية',
            'slug' => GeneralController::make_slug('الأدوية والمستحضرات الطبية'),
            'img' => 'files/post_categories/الأدوية والمستحضرات الطبية.jpg'
            ],
            [
            'name' => 'التغذية',
            'slug' => GeneralController::make_slug('التغذية'),
            'img' => 'files/post_categories/التغذية.jpg'
            ]
        ]);
    }
}
