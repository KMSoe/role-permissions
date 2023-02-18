<?php

namespace Modules\PopularProducts\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class PopularProductServiceProvider extends ServiceProvider
{

    public function boot()
    {
       $this->loadViewsFrom(base_path('Modules/PopularProducts/Views'), 'payment_methods'); 
    }
    
    public function register()
    {
        
    }
}
