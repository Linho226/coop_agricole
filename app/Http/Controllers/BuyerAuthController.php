<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BuyerAuthController extends Controller
{
    public function showRegister()
    {
        if (Auth::check() && Auth::user()->role === 'membre') {
            return redirect()->route('buyer.orders');
        }

        return view('public.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'membre',
            'actif' => true,
        ]);

        Auth::login($user);

        return redirect()->route('buyer.orders')->with('success', 'Compte acheteur créé avec succès.');
    }

    public function showLogin()
    {
        if (Auth::check() && Auth::user()->role === 'membre') {
            return redirect()->route('buyer.orders');
        }

        return view('public.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])->onlyInput('email');
        }

        if (! Auth::user()->actif || Auth::user()->role !== 'membre') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors(['email' => 'Ce formulaire est réservé aux acheteurs.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('buyer.orders'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.home');
    }
}
