<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekapitulasis', function (Blueprint $table) {
            $table->string('province_id')->after('tps_id');
            $table->string('regency_id')->after('province_id');
            $table->string('district_id')->after('regency_id');
            $table->string('village_id')->after('district_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekapitulasis', function (Blueprint $table) {
            //
        });
    }
}
