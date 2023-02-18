<?php

namespace Modules\Auth\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Modules\Auth\Http\Controllers'; 
    protected $namespaceApi = 'Modules\Auth\Http\Controllers\Api'; 
    protected $namespaceAdmin = 'Modules\Auth\Http\Controllers\Admin'; 
    public function boot()
    {
        parent::boot(); 
    }
    public function map()
    {
        $this->mapWebRoutes(); 
        $this->mapApiRoutes(); 
        $this->mapAdminRoutes(); 
    }
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('auth')
            ->group(base_path('Modules/Auth/routes/web.php')); 
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespaceApi)
            ->prefix('api/auth')
            ->group(base_path('Modules/Auth/routes/api.php')); 
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespaceAdmin)
            ->prefix('admin/auth')
            ->group(base_path('Modules/Auth/routes/admin.php')); 
    }
}