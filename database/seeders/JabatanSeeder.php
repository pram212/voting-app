<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatan = [
            ['nama' => 'PRESIDEN'],
            ['nama' => 'ANGGOTA DPR RI'],
            ['nama' => 'ANGGOTA DPR JAWA BARAT'],
            ['nama' => 'ANGGOTA DPR JAWA TENGAH'],
            ['nama' => 'ANGGOTA DPR JAWA TIMUR'],
            ['nama' => 'ANGGOTA DPR SUMATRA UTARA'],
            ['nama' => 'ANGGOTA DPR SUMUT BARAT'],
            ['nama' => 'KETUA DPD RI'],
            ['nama' => 'ANGGOTA DPD JAWA BARAT'],
            ['nama' => 'ANGGOTA DPD JAWA TENGAH'],
            ['nama' => 'ANGGOTA DPD JAWA TIMUR'],
        ];

        Jabatan::insert($jabatan);
    }
}
