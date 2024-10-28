<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TutorProduct;

class TutorProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        TutorProduct::factory(10)->create();
    }
}
