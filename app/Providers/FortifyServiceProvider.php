<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {

            $user = User::where('id_paciente', $request->id_paciente)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }elseif(!$user){
                $response = Http::get('http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies?includefield=all&PatientID='. $request->id_paciente);
                $paciente = $response->json();

                if ($paciente) {
                    $dni=$paciente[0]['00100020']['Value'][0];
                    $fnac=$paciente[0]['00100030']['Value'][0];
                    $name = str_replace("^", " ", $paciente[0]['00100010']['Value'][0]['Alphabetic']);

                    dd($dni.'-'.$fnac.'-'.$name);
                    User::create([
                        'name'=>$name,
                        'id_paciente' =>$dni,
                        'email'=>'pongaaqui@suemail.com',
                        'password'=>bcrypt($fnac)
                    ])->assignRole('Pacientes');

                    if ($request->password == $fnac){
                        return $user;
                    }
                }
            }
        });
    }
}
