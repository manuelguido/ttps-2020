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
        if(!$user) {
            return redirect()->to('login');
        } else { // El usuario existe y se logea
            // Actualiza la imagen del usuario en base a google
            $appUser->image = $user->avatar;
            $appUser->save();
            
            // Crea un token de acceso
            $passportToken = $appUser->createToken('Login token')->accessToken;

            // Create new view (I use callback.blade.php), and send the token and the name.
            return view('callback', [
                'user' => $appUser,
                'token' => $passportToken,
            ]);
            
            // return response()->json([
            //     'access_token' => $passportToken,
            // ]);
        }
        /* ENDLOGIC */        
    }
}
