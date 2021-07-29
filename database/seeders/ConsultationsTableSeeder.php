<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consultation;
use \App\Http\Controllers\GeneralController;

class ConsultationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents('public/json/consultations.json'));
        foreach($json as $el){
            Consultation::create([
                'title' => $el->title,
                'slug' => GeneralController::make_slug($el->title),
                'content' => $el->content,
                'views' => $el->views,
                'user_id' => $el->user_id,
                'consultation_category_id' => $el->consultation_category_id
            ]);
        }
    }
}
