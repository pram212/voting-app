<?php

namespace Database\Factories;

use App\Models\CalonPejabat;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Rekapitulasi;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;

class RekapitulasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'calon_pejabat_id' => $this->faker->randomElement(CalonPejabat::pluck('id')),
            'province_id' => $this->faker->randomElement(Province::pluck('id')),
            'regency_id' => $this->faker->randomElement(Regency::pluck('id')),
            'district_id' => $this->faker->randomElement(District::pluck('id')),
            'village_id' => $this->faker->randomElement(Village::pluck('id')),
            'rt' => $this->faker->numberBetween(1, 100),
            'rw' => $this->faker->numberBetween(1, 100),
            'jumlah_suara' => $this->faker->numberBetween(1, 200),
            'user_id' => $this->faker->randomElement(User::where('role', 2)->pluck('id')),
        ];
    }
}
