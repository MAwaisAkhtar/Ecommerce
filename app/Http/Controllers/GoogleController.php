<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

use Google_Client;
use Google_Service_Oauth2;

class GoogleController extends Controller
{
    public function googlepage(){
        // return socialite::google('driver')->redirect();
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope('https://www.googleapis.com/auth/userinfo.email');
        $client->addScope('https://www.googleapis.com/auth/userinfo.profile'); // Add this scope for user's name
        // $client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);

        return redirect($client->createAuthUrl());
        
    }


    public function googlecallback()
{
    $client = new Google_Client();
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));


    try {
        $accessToken = $client->fetchAccessTokenWithAuthCode(request('code'));
        $client->setAccessToken($accessToken);
        $service = new Google_Service_Oauth2($client);
        $userInfo = $service->userinfo->get();

        // Check if the user's email exists in the user table
        $user = User::where('email', $userInfo->email)->first();


        if ($user) {
            // If the user exists, log them in
            Auth::login($user);
        } else {
            
            // If the user does not exist, create a new user
            $newUser = User::create([
                'name' => $userInfo->name ?? 'Guest', // Use a default value 'Guest' if name is null
                'email' => $userInfo->email,
                'google_id' => $userInfo->id, // Store Google ID in the google_id column
                'password' => encrypt('123456dummy'),
                'email_verified_at' => now(),
            ]);

            // Log in the newly created user
            Auth::login($newUser);
        }

        // Redirect the user to the intended page (e.g., dashboard or home)
        return redirect()->intended('redirect');
    } catch (Exception $e) {
        // Handle authentication error
        return redirect('/login')->with('error', 'Google authentication failed.');
    }
}



    // public function googlecallback(){
    //     // try {
      
    //     //     $user = Socialite::driver('google')->user();
       
    //     //     $finduser = User::where('google_id', $user->id)->first();
       
    //     //     if($finduser)

    //     //     {
       
    //     //         Auth::login($finduser);
      
    //     //         return redirect()->intended('dashboard');
       
    //     //     }

    //     //     else

    //     //     {
    //     //         $newUser = User::create([
    //     //             'name' => $user->name,
    //     //             'email' => $user->email,
    //     //             'google_id'=> $user->id,
    //     //             'password' => encrypt('123456dummy')
    //     //         ]);
      
    //     //         Auth::login($newUser);
      
    //     //         return redirect()->intended('dashboard');
    //     //     }
      
    //     // } catch (Exception $e) {
    //     //     dd($e->getMessage());
    //     // }

    //     $client = new Google_Client();
    //     $client->setClientId(env('GOOGLE_CLIENT_ID'));
    //     $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    //     $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
    
    //     try {
    //         $accessToken = $client->fetchAccessTokenWithAuthCode(request('code'));
    //         $client->setAccessToken($accessToken);
    //         $service = new Google_Service_Oauth2($client);
    //         $userInfo = $service->userinfo->get();
    //         // Auth::login($user);
    //         dd($userInfo);

    //         // return redirect()->back();
    //     } catch (Exception $e) {
    //         // Handle authentication error
    //         return redirect('/login')->with('error', 'Google authentication failed.');
    //     }

    // }
}
