<?php declare(strict_types=1);

namespace App\Providers;

use App\Models\PersonalAccessToken;
use DateTime;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        Gate::policy(App\Models\Template::class, App\Policies\TemplatePolicy::class);

        $this->app['auth']->viaRequest('api', function ($request) {
            $tokenParts = explode('|', request()->bearerToken() ?? $request->input('api_token') ?? '');
            if (count($tokenParts) == 2) {
                $token = PersonalAccessToken::lookup($tokenParts[0], $tokenParts[1]);
                if (!empty($token)) {
                    $now = new DateTime();
                    if (!empty($token->expires_at) && $token->expires_at <= $now) {
                        return null;
                    }
                    return $token->user;
                }
            }
        });
    }
}
