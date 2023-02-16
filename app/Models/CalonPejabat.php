<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalonPejabat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nama', 'jabatan_id', 'no_urut'];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function rekapitulasi()
    {
        $this->hasMany(Rekapitulasi::class);
    }
    
}
