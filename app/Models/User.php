<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'password',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tps()
    {
        return $this->hasMany(TPS::class, 'village_id', 'village_id');
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
