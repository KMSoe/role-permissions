<?php

namespace Modules\PopularProducts\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

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
            ->prefix('popular-products')
            ->group(base_path('Modules/PopularProducts/routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->prefix('api/popular-products')
            ->group(base_path('Modules/PopularProducts/routes/api.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->prefix('admin/popular-products')
            ->group(base_path('Modules/PopularProducts/routes/admin.php'));
    }
}
