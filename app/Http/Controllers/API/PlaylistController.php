<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Emoji\Emoji;
use SpotifyWebAPI\SpotifyWebAPI as SpotifyApi;
use SpotifyWebAPI\Session as SpotifySession;

class PlaylistController extends Controller
{
    public function get(User $user)
    {
        if ( $user->id !== auth()->user()->id )
            return response()->json([
                'playlists' => [],
                'message' => [
                    'type' => 'danger',
                    'text' => Emoji::indexPointingUp().' Nah ah ah. You didn\'t say the magic word.',
                ]
            ], 200);

        $name = explode(' ', auth()->user()->name)[0];

        if ( !$user->spotify_access_token )
            return response()->json([
                'playlists' => [],
                'message' => [
                    'type' => 'info',
                    'text' => Emoji::confusedFace().' You need to sign in with Spotify to see your playlists.',
                ]
            ], 200);

        $api = new SpotifyApi();
        $accessTokenBody = $user->spotify_access_token;

        if ( $accessTokenBody['expires_at'] <= time() ) {
            $session = new SpotifySession(env('SPOTIFY_KEY'), env('SPOTIFY_SECRET'), env('SPOTIFY_REDIRECT_URI'));
            $session->refreshAccessToken($accessTokenBody['refresh_token']);

            $accessTokenBody['access_token'] = $session->getAccessToken();
            $accessTokenBody['expires_at'] = time() + $accessTokenBody['expires_in'];
            $user->spotify_access_token = $accessTokenBody;
            $user->save();
        }

        $api->setAccessToken($user->spotify_access_token['access_token']);

        $playlists = $api->getUserPlaylists($user->spotify_user_id, [
            'limit' => 50
        ]);

        $filteredPlaylists = [];
        foreach ( $playlists->items as $playlist ) {
            if ( $playlist->owner->id === $user->spotify_user_id )
                $filteredPlaylists['items'][] = $playlist;
        }

        $messageText = Emoji::backhandIndexPointingDown().' Here are your playlists, '.$name;
        if ( !$playlists ){
            $messageText = Emoji::loudlyCryingFace().' No playlists yet. What are you waiting for?';
        }

        return response()->json([
            'playlists' => $filteredPlaylists,
            'message' => [
                'type' => 'success',
                'text' => $messageText
            ]
        ], 200);
    }
}
