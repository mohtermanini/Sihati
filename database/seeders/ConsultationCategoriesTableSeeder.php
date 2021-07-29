<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConsultationCategory;
use \App\Http\Controllers\GeneralController;

class ConsultationCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConsultationCategory::insert([
            [
                'name' => 'أمراض أطفال',
                'slug' => GeneralController::make_slug('أمراض أطفال'),
                ],
                [
                'name' => 'أعصاب',
                'slug' => GeneralController::make_slug('أعصاب'),
                ],
                [
                'name' => 'أمراض العضلات والعظام والمفاصل',
                'slug' => GeneralController::make_slug('أمراض العضلات والعظام والمفاصل'),
                ]
        ]);
    }
}
