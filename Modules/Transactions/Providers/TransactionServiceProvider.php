<?php

namespace Modules\Transactions\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class TransactionServiceProvider extends ServiceProvider
{

    public function boot()
    {
       $this->loadViewsFrom(base_path('Modules/Transactions/Views'), 'transitions'); 
    }
    
    public function register()
    {
        
    }
}
