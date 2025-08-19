<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Departemen;

class RegisterController extends Controller
{
    // Tampilkan form register
    public function showRegistrationForm()
    {
        $departemens = Departemen::all(); // ambil semua data departemen
        return view('template.register', compact('departemens'));
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            // 'role' => 'required|in:asisten,krani,pelapor',
            'no_sap' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'departemen' => 'required|exists:departemens,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelapor',
            'no_sap' => $validated['no_sap'],
            'no_hp' => $validated['no_hp'],
            'departemen_id' => $validated['departemen'],
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
