<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(function(){
                    require(base_path('routes/api/products.php'));
                    require(base_path('routes/api/auth.php'));
                    require(base_path('routes/api/user.php'));
                    require(base_path('routes/api/organization.php'));
                    require(base_path('routes/api/licenses.php'));
                    require(base_path('routes/api/resources.php'));
                    require(base_path('routes/api/suppliers.php'));
                    require(base_path('routes/api/stock.php'));
                    require(base_path('routes/api/incomes_and_expenses.php'));
                    require(base_path('routes/api/prices.php'));
                    require(base_path('routes/api/price_modifiers.php'));
                });

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
