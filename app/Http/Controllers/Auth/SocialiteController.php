<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    // Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $this->loginOrCreateAccount($user, 'google');

            // Redirect to intended URL or home if not available
            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            \Log::error('Google login error: ' . $e->getMessage());

            return redirect()->route('login')->withErrors(['error' => 'Failed to login with Google.']);
        }
    }

    // Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();
            $this->loginOrCreateAccount($user, 'facebook');

            // Redirect to intended URL or home if not available
            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            \Log::error('Facebook login error: ' . $e->getMessage());

            return redirect()->route('login')->withErrors(['error' => 'Failed to login with Facebook.']);
        }
    }

    // Create account or login
    protected function loginOrCreateAccount($providerUser, $provider)
    {
        $user = User::where('provider_id', $providerUser->getId())->first();


        if (!$user) {
            $user = User::where('email', $providerUser->getEmail())->first();
            if ($user) {
                // Update the user with provider details
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $providerUser->getId(),
                    'avatar' => $providerUser->getAvatar(),
                ]);
            } else {
                // Create a new user if no user found with email
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $providerUser->getId(),
                    'avatar' => $providerUser->getAvatar(),
                    'password' => Hash::make('my-google'),
                ]);
            }
        }


        Auth::login($user);
    }
}
