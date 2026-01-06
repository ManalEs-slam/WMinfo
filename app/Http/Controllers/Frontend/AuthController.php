<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('public.auth.login');
    }

    public function showRegister()
    {
        return view('public.auth.register');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = $request->user();

            if ($user && $user->status === 'inactive') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->with('error', 'Compte inactif.');
            }

            if ($user && $user->role !== User::ROLE_READER) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        }

        return back()->with('error', 'Identifiants invalides.')->withInput();
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => trim($data['first_name'] . ' ' . $data['last_name']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'role' => User::ROLE_READER,
            'status' => 'active',
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
