<?php

namespace Database\Seeders;

use App\Models\Rekapitulasi;
use Illuminate\Database\Seeder;

class RekapitulasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rekapitulasi::factory(10)->create();
    }
}
