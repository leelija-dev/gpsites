<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Auth\Events\Verified;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;
// use Illuminate\Http\RedirectResponse;

// class VerifyEmailController extends Controller
// {
//     /**
//      * Mark the authenticated user's email address as verified.
//      */
//     public function __invoke(EmailVerificationRequest $request): RedirectResponse
//     {
//         if ($request->user()->hasVerifiedEmail()) {
//             return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
//         }

//         if ($request->user()->markEmailAsVerified()) {
//             event(new Verified($request->user()));
//         }

//         return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
//     }
// }


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     */
    public function __invoke(Request $request, $id, $hash): RedirectResponse
    {
       
        // Find the user by ID
        $user = User::find($id);
//  dd($user);  die;
        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid verification link.');
        }

        // Check if the hash matches
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')->with('error', 'Invalid verification link.');
        }

        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            if (Auth::check()) {
               
                return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
            } else {
                 
                return redirect()->route('login')->with('success', 'Email already verified. Please log in.');
            }
        }

        // Mark email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            
            // Log the user in after verification
            Auth::login($user);
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}