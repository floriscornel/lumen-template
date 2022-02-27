<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->environment('testing')) {
            $this->app->singleton(\Illuminate\Contracts\Routing\ResponseFactory::class, function () {
                return new \Laravel\Lumen\Http\ResponseFactory();
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        switch (env('APP_ENV')) {
            case 'test':
            case 'staging':
            case 'production':
                URL::forceScheme('https');
                break;
        }
    }
}
