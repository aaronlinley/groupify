<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Emoji\Emoji;
use SpotifyWebAPI\Session as SpotifySession;
use SpotifyWebAPI\SpotifyWebAPI as SpotifyApi;

class UserController extends Controller
{
    public function get(User $user)
    {
        $userDetails = [
            'name' => $user->name,
            'spotifyUserId' => $user->spotify_user_id ? $user->spotify_user_id : '',
        ];

        return response()->json([
            'user' => $userDetails
        ], 200);
    }

    public function update(User $user, Request $request)
    {
        if ( $user->id !== auth()->user()->id )
            return response()->json([
                'message' => [
                    'type' => 'danger',
                    'text' => Emoji::indexPointingUp().' Nah ah ah. You didn\'t say the magic word.',
                ]
            ], 200);

        $toUpdate = false;
        if ( $request->name && $request->name !== $user->name ) {
            $user->name = $request->name;
            $toUpdate = true;
        }

        if ( $toUpdate )
            $user->save();

        return response()->json([
            'message' => [
                'type' => 'success',
                'text' => $toUpdate ? Emoji::okHand().' User updated!' : Emoji::personShrugging().' Nothin\' to update.'
            ]
        ], 200);
    }
}
