<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace App\Models;

use AzisHapidin\IndoRegion\Traits\ProvinceTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Province Model.
 */
class Province extends Model
{
    use ProvinceTrait;
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'provinces';

    public $timestamps = false;

    protected $fillable = ['id','name'];

    /**
     * Province has many regencies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }

    public function tps()
    {
        return $this->hasMany(TPS::class, 'province_id', 'id');
    }

    public function rekapan()
    {
        return $this->hasMany(Rekapitulasi::class);
    }

    public function saksi()
    {
        return $this->hasMany(User::class);
    }
}
