<?php

namespace App\Providers;

use App\Models\Calon;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Rekapitulasi;
use App\Models\TPS;
use App\Models\User;
use App\Models\Village;
use App\Policies\CalonPolicy;
use App\Policies\DistrictPolicy;
use App\Policies\ProvinsePolicy;
use App\Policies\RegencyPolicy;
use App\Policies\RekapitulasiPolicy;
use App\Policies\TPSPolicy;
use App\Policies\UserPolicy;
use App\Policies\VillagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Calon::class => CalonPolicy::class,
        TPS::class => TPSPolicy::class,
        User::class => UserPolicy::class,
        Rekapitulasi::class => RekapitulasiPolicy::class,
        Province::class => ProvinsePolicy::class,
        Regency::class => RegencyPolicy::class,
        District::class => DistrictPolicy::class,
        Village::class => VillagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
