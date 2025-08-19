<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('template.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'no_sap' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['no_sap' => $credentials['no_sap'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'asisten') {
                return redirect()->route('beranda'); // misal: template.dashboard
            } elseif ($user->role === 'krani') {
                return redirect()->route('krani.dashboard');
            } elseif ($user->role === 'pelapor') {
                return redirect()->route('pelapor.dashboard'); // atau buat route khusus pelapor
            } else {
                Auth::logout(); // role tidak dikenal
                return redirect()->route('login')->withErrors(['role' => 'Role tidak valid.']);
            }
        }

        return back()->with('error', 'No. SAP atau Password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
