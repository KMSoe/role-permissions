<?php

namespace Modules\Articles\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class ArticleServiceProvider extends ServiceProvider
{
    public function boot()
    {
       $this->loadViewsFrom(base_path('Modules/Articles/Views'), 'articles'); 
    }
    
    public function register()
    {
        
    }
}
