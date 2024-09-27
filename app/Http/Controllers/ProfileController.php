<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();
        return view('dashboard.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'old_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Mengambil data user yang login
        $user = Auth::user();
    
        // Proses upload foto jika ada
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::delete('public/' . $user->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('fotos', 'public');
        }
    
        // Validasi dan update password jika diisi
        if ($request->filled('old_password') && Hash::check($request->old_password, $user->password)) {
            if ($request->filled('password')) {
                // Hanya update password jika ada input password baru
                $validatedData['password'] = Hash::make($request->password);
            }
        } elseif ($request->filled('old_password')) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        } else {
            // Jika password tidak diubah, hapus dari array validatedData agar tidak ikut diupdate
            unset($validatedData['password']);
        }
    
        // Update profil secara langsung tanpa menggunakan save()
        $user->update($validatedData);
    
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }
    
}
