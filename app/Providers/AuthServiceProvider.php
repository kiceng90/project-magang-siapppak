<?php

namespace App\Providers;

use App\Models\DaftarKlien;
use App\Models\DKonselor;
use App\Models\Pengaduan;
use App\Models\Pkbm;
use App\Models\PsikologVolunteer;
use App\Models\SatgasPpa;
use App\Policies\DaftarKlienPolicy;
use App\Policies\DKonselorPolicy;
use App\Policies\PengaduanPolicy;
use App\Policies\PkbmPolicy;
use App\Policies\PsikologVolunteerPolicy;
use App\Policies\SatgasPpaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        PsikologVolunteer::class => PsikologVolunteerPolicy::class,
        Pkbm::class => PkbmPolicy::class,
        DKonselor::class => DKonselorPolicy::class,
        SatgasPpa::class => SatgasPpaPolicy::class,
        DaftarKlien::class => DaftarKlienPolicy::class,
        Pengaduan::class => PengaduanPolicy::class,
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
