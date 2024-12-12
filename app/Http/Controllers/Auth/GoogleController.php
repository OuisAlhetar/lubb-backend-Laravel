<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $authUser = User::updateOrCreate(
            ['google_id' => $user->id],
            [
                'email' => $user->email,
                'name' => $user->name ?? 'user_' . Str::random(8),
                'password'=> Hash::make("password"),
            ]
        );

        // Generate a token for the authenticated user
        $token = $authUser->createToken('auth_token')->plainTextToken;

        // Redirect to the frontend app with token and username
        return redirect()->to("http://localhost:5173/?token={$token}&username={$authUser->name}");
    }


    // public function handleGoogleCallback()
    // {
    //     try {
    //         $googleUser = Socialite::driver('google')->user();


    //         // Find or create the user
    //         $user = User::firstOrCreate(
    //             ['email' => $googleUser->getEmail()],
    //             [
    //                 'username' => $googleUser->getName(),
    //                 'google_id' => $googleUser->getId(),
    //                 'password' => Hash::make("ouis1234"), // Generate a random password
    //             ]
    //         );

    //         // Generate a Sanctum token for the user
    //         $token = $user->createToken('google-login')->plainTextToken;

    //         return response()->json([
    //             'token' => $token,
    //             'user' => $user,
    //         ], 200);
    //     } catch (Exception $e) {
    //         return response()->json(['error' => 'Failed to login with Google.'], 500);
    //     }
        
    // }

}


