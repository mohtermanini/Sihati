<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountType;


class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountType::insert([
            [
                'name' => 'admin'
            ],
            [
                'name' => 'normal'
            ],
            [
                'name' => 'doctor'
            ],
            
        ]);
    }
}
