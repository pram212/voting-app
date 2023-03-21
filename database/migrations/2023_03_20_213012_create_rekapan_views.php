<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRekapanViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW rekapan_views AS
            SELECT 
                tb_prov.id AS id_provinsi, 
                tb_rege.id AS id_kota,  
                tb_dist.id AS id_kecamatan,
                tb_vill.id AS id_desa,
                tb_rekap.jumlah_suara AS jumlah_suara,
                tb_tps.id AS id_tps,
                tb_calon.id AS id_calon
            FROM rekapitulasis tb_rekap
                LEFT JOIN calons tb_calon ON tb_rekap.calon_id = tb_calon.id
                LEFT JOIN tps tb_tps ON tb_rekap.tps_id = tb_tps.id 
                LEFT JOIN provinces tb_prov ON tb_tps.province_id = tb_prov.id
                LEFT JOIN regencies tb_rege ON tb_tps.regency_id = tb_rege.id
                LEFT JOIN districts tb_dist ON tb_tps.district_id = tb_dist.id
                LEFT JOIN villages tb_vill ON tb_tps.village_id = tb_vill.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW rekapan_views");
    }
}
