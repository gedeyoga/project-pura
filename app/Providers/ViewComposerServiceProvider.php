<?php

namespace App\Providers;

use App\Http\Composers\MainViewComposer;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
 
    public function boot()
    {
        view()->composer("layouts.main", MainViewComposer::class);
    }
}
