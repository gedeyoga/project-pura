<?php

namespace App\Providers;

use App\Models\SensorPintu;
use App\Models\JenisPura;
use App\Models\Pura;
use App\Models\Role;
use App\Models\SensorCctv;
use App\Models\User;
use App\Repositories\Eloquent\EloquentSensorPintuRepository;
use App\Repositories\Eloquent\EloquentJenisPuraRepository;
use App\Repositories\Eloquent\EloquentPuraRepository;
use App\Repositories\Eloquent\EloquentRoleRepository;
use App\Repositories\Eloquent\EloquentSensorCctvRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\SensorPintuRepository;
use App\Repositories\JenisPuraRepository;
use App\Repositories\PuraRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SensorCctvRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, function () {

            $repository = new EloquentUserRepository(new User());

            return $repository;
        });

        $this->app->bind(RoleRepository::class, function () {

            $repository = new EloquentRoleRepository(new Role());

            return $repository;
        });

        $this->app->bind(SensorPintuRepository::class, function () {

            $repository = new EloquentSensorPintuRepository(new SensorPintu());

            return $repository;
        });

        $this->app->bind(PuraRepository::class, function () {

            $repository = new EloquentPuraRepository(new Pura());

            return $repository;
        });

        $this->app->bind(JenisPuraRepository::class, function () {

            $repository = new EloquentJenisPuraRepository(new JenisPura());

            return $repository;
        });

        $this->app->bind(SensorCctvRepository::class, function () {

            $repository = new EloquentSensorCctvRepository(new SensorCctv());

            return $repository;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
