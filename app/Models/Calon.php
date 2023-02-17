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
        return $this->belongsToMany(TPS::class, 'tps', 'calon_id', 'tps_id', 'id');
    }
    
}
