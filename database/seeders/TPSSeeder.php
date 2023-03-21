<?php

namespace Database\Seeders;

use App\Models\Calon;
use App\Models\Rekapitulasi;
use App\Models\TPS;
use Illuminate\Database\Seeder;

class TPSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tpsCount = 100; // jumlah TPS yang ingin dibuat
        $calons = Calon::all();

        for ($i = 1; $i <= $tpsCount; $i++) {
            $tps = TPS::factory()->create();

            foreach ($calons as $calon) {
                Rekapitulasi::create([
                    'tps_id' => $tps->id,
                    'calon_id' => $calon->id,
                    'jumlah_suara' => rand(1, 100),
                    'province_id' => $tps->province_id,
                    'regency_id' => $tps->regency_id,
                    'district_id' => $tps->district_id,
                    'village_id' => $tps->village_id,
                ]);
            }
        }

    }
}
