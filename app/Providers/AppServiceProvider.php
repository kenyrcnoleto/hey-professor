<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
        Model::unguard();
        //importante que o erro apareça somente em ambiente de desenvolvimento - previne o excesso que queries no relacionamento
        Model::preventLazyLoading(!app()->isProduction());
    }
}
