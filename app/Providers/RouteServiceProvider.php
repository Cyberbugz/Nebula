<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->registerModuleApiRoutes();

            Route::middleware('test')
                ->prefix('test')
                ->group(base_path('routes/test.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function registerModuleApiRoutes()
    {
        $registrar = Route::prefix('api')->middleware('api');

        $modulesPath = base_path('app/Modules');
        $modules = array_filter(scandir($modulesPath), fn($module) => !in_array($module, ['.', '..']));
        foreach ($modules as $module) {
            $apiRoutes = $modulesPath . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'Routes/api.php';
            if (file_exists($apiRoutes)) {
                $registrar->group($apiRoutes);
            }
        }
    }
}
