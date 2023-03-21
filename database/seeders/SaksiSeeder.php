<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(500)->create();
    }
}