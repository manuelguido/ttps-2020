<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
// use Laravel\Socialite\Facades\Socialite;
use Socialite;
use App\User;
use Session;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $provider = 'google';
        
        // Usuario obtenido de google
        $user = Socialite::driver($provider)->stateless()->user();

        /* LOGIC */
        // Usuario dentro de la applicación
        $appUser = User::getByEmail($user->email);

        // El usuario no existe
        if(!$appUser) {
            // Retorna la vista.
            return view('callback_no_user');

        // El usuario existe y se logea
        } else {
            // Actualiza la imagen del usuario en base a google
            $appUser->image = $user->avatar;
            $appUser->name = $user->user['given_name'];
            $appUser->lastname = $user->user['family_name'];
            $appUser->save();
            
            // Crea un token de acceso
            $passportToken = $appUser->createToken('Login token')->accessToken;

            // Retorna la vista.
            return view('callback', [
                'user' => $appUser,
                'token' => $passportToken,
            ]);
        }
    }
}
