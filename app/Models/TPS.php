<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TPS extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tps';

    protected $fillable = ['province_id', 'regency_id', 'district_id', 'village_id', 'nomor', 'catatan', 'user_id'];

    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function kota()
    {
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function desa()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'village_id', 'village_id');
    }

    public function userEntry()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function calon()
    {
        return $this->belongsToMany(Calon::class, 'rekapitulasis', 'tps_id', 'calon_id')
                        ->withPivot('jumlah_suara', 'created_at', 'updated_at');
    }
}
