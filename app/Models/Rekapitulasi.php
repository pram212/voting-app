<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rekapitulasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function calonPejabat()
    {
        return $this->belongsTo(CalonPejabat::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function kota()
    {
        return $this->belongsTo(Regency::class, 'regency_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function desa()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

}
