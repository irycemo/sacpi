<?php

namespace App\Providers;

use Livewire\Livewire;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
//use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Model::shouldBeStrict();

        if(app()->isProduction()){

            URL::forceScheme('https');

            Livewire::setScriptRoute(function ($handle) {
                return Route::get('/sgc/public/vendor/livewire/livewire.js', $handle);
            });

            Livewire::setUpdateRoute(function ($handle) {
                return Route::post('/sgc/livewire/update', $handle);
            });

        }

        if(app()->environment('staging')){

            Livewire::setScriptRoute(function ($handle) {
                return Route::get('/sgc/public/vendor/livewire/livewire.js', $handle);
            });

            Livewire::setUpdateRoute(function ($handle) {
                return Route::post('/sgc/livewire/update', $handle);
            });

        }

    }
}
