<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Http\Responses\LogoutResponse;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

    // Personalizar la redirección después de cerrar sesión
    $this->app->singleton(LogoutResponse::class, function () {
        return new class extends LogoutResponse {
            public function toResponse($request)
            {
                return $request->wantsJson()
                    ? response()->json(['message' => 'Logged out'])
                    : redirect('/login');
            }
        };
    });

    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
