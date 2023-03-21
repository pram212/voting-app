<?php

namespace Database\Seeders;

use App\Models\Calon;
use App\Models\TPS;
use Illuminate\Database\Seeder;

class CalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Calon::factory(5)->create();
    }
}
