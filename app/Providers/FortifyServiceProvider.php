<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Responses\LogoutResponse;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LogoutResponse::class, new class extends LogoutResponse {
            public function toResponse($request)
            {
                return redirect('/');
            }
        });
    }

    public function boot(): void
    {

        Fortify::loginView(fn()=>view('auth.login'));
        Fortify::registerView(fn()=>view('auth.register'));
        Fortify::requestPasswordResetLinkView(fn()=>view('auth.forgot-password'));
        Fortify::resetPasswordView(fn(Request $request)=>view('auth.reset-password',['request' => $request]));
        Fortify::verifyEmailView(fn() => view('auth.verify-email'));
//      -----------------------
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

    }

}
