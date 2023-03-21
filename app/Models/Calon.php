<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['no_urut', 'keterangan'];
    
    public function tps()
    {
        return $this->belongsToMany(TPS::class, 'rekapitulasis', 'calon_id', 'tps_id')
                        ->withPivot('jumlah_suara', 'created_at', 'updated_at');
    }

    public function rekapan()
    {
        return $this->hasMany(RekapanView::class, 'id_calon', 'id');
    }

}
