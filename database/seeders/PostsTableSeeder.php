<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use \App\Http\Controllers\GeneralController;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents('public/json/posts.json'));
        foreach($json as $el){
            Post::create([
                'title' => $el->title,
                'slug' => GeneralController::make_slug($el->title),
                'content' => $el->content,
                'views' => $el->views,
                'likes' => $el->likes,
                'img' => $el->img,
                'post_category_id' => $el->postCategoryId
            ]);
        }
    }
}
