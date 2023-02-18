<?php

namespace Modules\Topups\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class TopupServiceProvider extends ServiceProvider
{

    public function boot()
    {
       $this->loadViewsFrom(base_path('Modules/Topups/Views'), 'topups'); 
    }
    
    public function register()
    {
        
    }
}
