<?php

namespace Database\Factories;

use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class TPSFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $provinsi = Province::inRandomOrder()->first();
        $kota = $provinsi->regencies()->inRandomOrder()->first();
        $kecamatan = $kota->districts()->inRandomOrder()->first();
        $desa = $kecamatan->villages()->inRandomOrder()->first();

        return [
            'nomor' => $this->faker->swiftBicNumber(),
            'province_id' => $provinsi->id,
            'regency_id' => $kota->id,
            'district_id' => $kecamatan->id,
            'village_id' => $desa->id,
            'created_at' => now(),
        ];
    }
}
