<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class SetupPasswordController extends Controller
{
    /**
     * Display the password setup view.
     */
    public function showSetupForm(Request $request, $token)
    {
        return view('auth.passwords.setup', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Set up the user's password.
     */
    public function setup(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            // Redirigir a una página de confirmación en lugar del dashboard
            return redirect()->route('password.setup.complete');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}
