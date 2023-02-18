<?php

namespace Modules\Categories\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class CategoryServiceProvider extends ServiceProvider
{

    public function boot()
    {
       $this->loadViewsFrom(base_path('Modules/Categories/Views'), 'categories'); 
    }
    
    public function register()
    {
        
    }
}
