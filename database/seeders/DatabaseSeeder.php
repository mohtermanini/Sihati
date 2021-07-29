<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* Slides */
        $this->call(SlidesTableSeeder::class);
        /* Slides */

        /* Users */
        $this->call(AccountTypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(JobProfileTableSeeder::class);
        /* Users */

        /* Posts */
        $this->call(PostCategoriesTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(PostTagTableSeeder::class);
        $this->call(PostUserTableSeeder::class);
        $this->call(PostViewsTableSeeder::class);
        /* Posts */
       
        /* Consultations */
        $this->call(ConsultationCategoriesTableSeeder::class);
        $this->call(ConsultationsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(ConsultationViewsTableSeeder::class);
        /* Consultations */
        
        


    }
}
