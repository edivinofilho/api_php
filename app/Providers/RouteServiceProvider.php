<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot(): void {

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        
        $this->routes(function () {
            //Log::debug(base_path('routes/api));
            $dirs = scandir($path = base_path('routes/api'));
            $dirsWithoutDot = array_diff($dirs, ['..', '.']);

            foreach($dirsWithoutDot as $dir) {
                if(file_exists($file = "{$path}/{$dir}")){
                    
                    Route::middleware('api')
                        ->prefix('api')
                        ->group($file);
                }
            }


            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
