<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role as ModelsRole;

class UserController extends Controller
{
    // Menampilkan halaman index dengan data pengguna dan role-nya
    public function index()
    {
        $users = User::with('roles')->get();  // Ambil semua user dengan roles-nya
        $roles = ModelsRole::all();  // Ambil semua role dari database
    
        return view('dashboard.auth.index', compact('users', 'roles')); 
    }

    // Fungsi untuk menghapus user
    public function destroy($id)
    {
        // Menghapus user berdasarkan ID
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('auth.index')->with('success', 'User berhasil dihapus');
    }

    // Fungsi untuk menyimpan pengguna baru
    public function store(Request $request)
{
    
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'role' => 'required'
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign role ke pengguna baru
        $user->assignRole($request->role);

        return redirect()->route('auth.index')->with('success', 'User berhasil dibuat!');
    
}



    // Fungsi untuk memperbarui pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8', // Password tidak wajib diisi
            'role' => 'required'
        ]);
    
        // Update user, jika password ada, maka di-update, jika tidak tetap gunakan password lama
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // Update password hanya jika ada input password, jika tidak, tetap gunakan password lama
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
        ]);
    
        // Sinkronisasi role
        $user->syncRoles($validated['role']);
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('auth.index')->with('success', 'User berhasil diperbarui!');
    }
    

    // Fungsi untuk menampilkan form create (tambah pengguna)
    public function create()
    {
        return view('dashboard.auth.create');
    }

public function bulkDelete(Request $request)
    {
        // Validasi bahwa request memiliki array ID
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id', // Setiap ID harus ada di tabel 'users'
        ]);

        // Ambil daftar user berdasarkan ID yang dikirim
        $userList = User::whereIn('id', $request->ids)->get();

        foreach ($userList as $user) {
            // Hapus foto dari storage jika ada (asumsi nama file disimpan di 'foto')
            if ($user->foto) {
                // Pastikan menggunakan storage public
                Storage::delete('public/' . $user->foto);
            }

            // Hapus user dari database
            $user->delete();
        }

        // Kembalikan respons JSON untuk menunjukkan bahwa penghapusan berhasil
        return response()->json(['success' => true, 'message' => 'Data pengguna berhasil dihapus.']);
    }

}
