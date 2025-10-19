<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        Log::info('=== GOOGLE OAUTH REDIRECT STARTED ===');
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        Log::info('=== GOOGLE OAUTH CALLBACK STARTED ===');
        
        try {
            Log::info('Attempting to get Google user from Socialite...');
            $googleUser = Socialite::driver('google')->user();
            
            Log::info('Google user data received:', [
                'google_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'avatar' => $googleUser->getAvatar()
            ]);

            // Check if user exists by email
            Log::info('Checking if user exists by email: ' . $googleUser->getEmail());
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                Log::info('Existing user found:', [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'current_google_id' => $user->google_id
                ]);

                // Update Google ID if not set
                if (empty($user->google_id)) {
                    Log::info('Updating user with Google ID');
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            } else {
                Log::info('Creating new user from Google OAuth');
                
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)),
                    'account_number' => (string) rand(10000000, 99999999),
                    'status' => 'active',
                    'account_type' => 'personal',
                    'balance' => 0,
                    'avatar' => $googleUser->getAvatar(),
                ]);

                Log::info('New user created successfully:', ['user_id' => $user->id]);
            }

            // Log the user in
            Log::info('Attempting to login user:', ['user_id' => $user->id]);
            Auth::login($user, true);
            
            Log::info('User login successful, redirecting to dashboard');

            return redirect()->route('dashboard')->with('success', 'Welcome to Oarkard Bank!');

        } catch (\Exception $e) {
            Log::error('=== GOOGLE OAUTH ERROR ===', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('login')->with('error', 'Google authentication failed. Please try again.');
        }
    }
}