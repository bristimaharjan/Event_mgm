<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
        public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin,vendor',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        return redirect()
       ->route('login.form')  
       ->with('success', 'Welcome, ' . $user->name . '! Your account has been created.');
  
    }

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credential = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();

            $user = Auth::user(); // get the authenticated user

            if ($user->role === 'admin') {
                return redirect()->route('chirps.adminIndex');
            } elseif ($user->role === 'vendor') {
            return redirect()->route('vendor.dashboard'); // automatically goes to their own dashboard
            }

            return redirect()->route('welcome');
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}
