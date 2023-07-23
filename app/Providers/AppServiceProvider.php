<?php

namespace App\Providers;

use App\Models\GedongSimpen;
use App\Models\User;
use App\Repositories\Eloquent\EloquentGedongSimpenRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\GedongSimpenRepository;
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
        $this->app->bind(GedongSimpenRepository::class, function () {

            $repository = new EloquentGedongSimpenRepository(new GedongSimpen());

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
