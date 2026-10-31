<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $demoUsers = User::all();

        return view('auth.login', compact('demoUsers'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session->regenerate();

            return redirect()->intended(route('dashboard'));
             ->with('success', 'Selamat datang kembali, '.Auth::user()->name.'!');

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email'); 
        }
    }

    public function quicklogin(Request $request): RedirectRsponse
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id']
        ]);

        $user = User::find($request->user_id);
        Auth::login($user);

        return redirect()->route('dashboard');
         ->with('success', 'Berhasil alih akun sebagai:'.$user->name.' ('.user->role->label().')');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

}
