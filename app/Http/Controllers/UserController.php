<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Departemen;

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_sap', 'like', "%{$search}%");
            })
            ->paginate(10);
        return view('template.user', compact('users'));
    }
    public function create()
    {
        $departemens = Departemen::all();
        return view('template.user_create', compact('departemens'));
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'no_sap' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'departemen' => 'required|exists:departemens,id',
            'role' => 'required|in:asisten,krani,pelapor',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_sap' => $validated['no_sap'],
            'no_hp' => $validated['no_hp'],
            'departemen_id' => $validated['departemen'],
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('template.show', compact('user'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $departemens = Departemen::all();

        return view('template.edit', compact('user', 'departemens'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:asisten,krani,pelapor',
            'no_sap' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'departemen_id' => 'required|exists:departemens,id',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Gagal menghapus pengguna.');
        }
    }
}
