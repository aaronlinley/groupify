<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use SpotifyWebAPI\SpotifyWebAPI as SpotifyApi;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Spotify authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::with('spotify')
            ->scopes([
                'playlist-read-private',
                'playlist-modify-public',
                'playlist-read-collaborative',
                'user-read-private',
            ])
            ->redirect();
    }

    /**
     * Obtain the user information from Spotify.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('spotify')->user();

        $user->accessTokenResponseBody['expires_at'] = time() + $user->accessTokenResponseBody['expires_in'];

        if ( !$laravelUser = User::where('spotify_user_id', $user->id)->first() ) {
            $laravelUser = User::create([
                'name' => $user->name,
                'email' => $user->email ? $user->email : 'user_'.$user->id.'@groupify.com',
                'password' => Hash::make($user->id),
                'spotify_user' => 1,
                'spotify_user_id' => $user->id,
                'spotify_access_token' => $user->accessTokenResponseBody
            ]);
        }

        Auth::login($laravelUser);
        return redirect($this->redirectTo);
    }
}
