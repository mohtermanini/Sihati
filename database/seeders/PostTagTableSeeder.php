<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostTag;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostTag::insert([
            [
                'post_id' => 1,
                'tag_id' => 1
            ],
            [
                'post_id' => 1,
                'tag_id' => 2
            ],
            [
                'post_id' => 1,
                'tag_id' => 3
            ],
            [
                'post_id' => 4,
                'tag_id' => 4
            ],
            [
                'post_id' => 4,
                'tag_id' => 5
            ],
            [
                'post_id' => 5,
                'tag_id' => 6
            ],
            [
                'post_id' => 2,
                'tag_id' => 7
            ],
            [
                'post_id' => 2,
                'tag_id' => 3
            ],
            [
                'post_id' => 3,
                'tag_id' => 8
            ],
            [
                'post_id' => 3,
                'tag_id' => 9
            ]
        ]);
    }
}
