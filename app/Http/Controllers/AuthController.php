<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handles authentication.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'login.welcome.error.email.required',
            'email.email' => 'login.welcome.error.email.email',
            'password.required' => 'login.welcome.error.password.required',
        ]);

        if (Auth::attempt($credentials + ['is_active' => true])) {
            $request->session()->regenerate();
 
            return to_route('index');
        }

        return back()->withErrors([
            'email' => 'login.welcome.error.auth',
        ])->onlyInput('email');
    }

    /**
     * Handles logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('index');
    }
}
