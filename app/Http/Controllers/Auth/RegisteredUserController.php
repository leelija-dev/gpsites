<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Start database transaction
        return DB::transaction(function () use ($request) {
            try {
                $validated = $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ]);

                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                ]);

                // Fire the registered event
                event(new Registered($user));

                // Commit the transaction
                DB::commit();

                return redirect(route('verification.notice', absolute: false))
                    ->with('status', 'Registration successful! Please check your email to verify your account.');

            } catch (\Illuminate\Validation\ValidationException $e) {
                // Re-throw validation exceptions to maintain default behavior
                throw $e;
            } catch (\Illuminate\Database\QueryException $e) {
                // Rollback transaction on database errors
                DB::rollBack();
                
                $errorMessage = 'A database error occurred during registration. ';
                
                // More specific error messages based on error code
                if ($e->errorInfo[1] == 1062) {
                    $errorMessage = 'This email is already registered. Please use a different email or try to log in.';
                }
                
                Log::error('Database error during registration: ' . $e->getMessage(), [
                    'error' => $e->errorInfo,
                    'email' => $request->email,
                    'ip' => $request->ip()
                ]);

                return back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->withErrors(['error' => $errorMessage]);
                    
            } catch (\Exception $e) {
                // Rollback transaction on any other errors
                DB::rollBack();
                
                Log::error('Unexpected error during registration: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'email' => $request->email,
                    'ip' => $request->ip(),
                    'trace' => $e->getTraceAsString()
                ]);

                return back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->withErrors([
                        'error' => 'An unexpected error occurred. Our team has been notified. Please try again later.'
                    ]);
            }
        });
    }
}