<?php

namespace App\Providers;

use App\Auth\MyAuthUserProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class MyAuthProvider extends ServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('custom', function($app, array $config){
            return new MyAuthUserProvider();
        });
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
}