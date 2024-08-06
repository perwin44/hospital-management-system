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
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard_user';

    public const ADMIN = '/dashboard_admin';
    public const DOCTOR = '/dashboard_doctor';
    public const RayEmployee = '/dashboard_ray_employee';
    public const LABORATORIEEmployee = '/dashboard_laboratorie_employee';
    public const PATIENT = '/dashboard_patient';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->group(base_path('routes/Backend.php'));
            Route::middleware('web')
                // ->prefix('doctor')
                ->group(base_path('routes/doctor.php'));
            Route::middleware('web')
                ->group(base_path('routes/ray_employee.php'));
            Route::middleware('web')
                ->group(base_path('routes/laboratorie_employee.php'));
            Route::middleware('web')
                ->group(base_path('routes/patient.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
