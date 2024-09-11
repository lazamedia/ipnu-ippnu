<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    public function index()
    {
        $pengurus = Pengurus::all(); 
        return view('dashboard.pengurus.index', compact('pengurus'));
    }

    public function create()
    {
        return view('dashboard.pengurus.create');
    }

    public function store(Request $request)
    {
        // Validasi input pengurus
        $data = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar maksimal 2MB
            'nama_lengkap' => 'required|string|max:255',
            'no_wa' => 'required|string|max:15|unique:users,username',  // Nomor WA digunakan sebagai username
            'email' => 'nullable|email|unique:users,email',
            'divisi' => 'required|string',
            'pelajar' => 'required|string',
        ]);
    
        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            // Simpan gambar di storage/fotos
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }
    
        // Simpan data pengurus ke database
        $pengurus = Pengurus::create($data);
    
        // Buat akun user otomatis
        $user = User::create([
            'name' => $data['nama_lengkap'],
            'foto' => $data['foto'],
            'username' => $data['no_wa'],  // Nomor WA sebagai username
            'email' => $data['email'],
            'password' => bcrypt('ipnuippnupujut'),  // Password default
        ]);
    
        // Assign role 'admin' ke user
        $user->assignRole('admin');
    
        return redirect()->route('pengurus.index')->with('success', 'Pengurus dan akun user berhasil dibuat dengan role admin.');
    }


    public function show($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        return view('dashboard.pengurus.show', compact('pengurus'));
    }

    public function edit($id)
{
    $pengurus = Pengurus::findOrFail($id);
     // Lakukan debugging untuk memastikan path gambar ada
    return view('dashboard.pengurus.edit', compact('pengurus'));
}


    public function update(Request $request, $id)
    {
       $data = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
            'nama_lengkap' => 'required',
            'divisi' => 'required',
            'no_wa' => 'required',
            'email' => 'nullable|email',
            'pelajar' => 'required',
        ]);

        $pengurus = Pengurus::findOrFail($id);
        if ($request->hasFile('foto')) {
            if ($pengurus->foto) {
                Storage::delete('public/' . $pengurus->foto);
            }
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }


        
        $pengurus->update($data);
        // $pengurus->nama_lengkap = $request->nama_lengkap;
        // $pengurus->divisi = $request->divisi;
        // $pengurus->no_wa = $request->no_wa;
        // $pengurus->email = $request->email;
        // $pengurus->pelajar = $request->pelajar;
        // $pengurus->save();

        return redirect('dashboard/pengurus')->with('success', 'Pengurus berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        $pengurus->delete();

        return redirect('dashboard/pengurus')->with('success', 'Pengurus berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
{
    // Validasi bahwa request memiliki array ID
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:pengurus,id',
    ]);

    // Ambil daftar pengurus berdasarkan ID yang dikirim
    $pengurusList = Pengurus::whereIn('id', $request->ids)->get();

    foreach ($pengurusList as $pengurus) {
        // Hapus foto dari storage jika ada
        if ($pengurus->foto) {
            // Pastikan menggunakan storage public
            Storage::delete('public/' . $pengurus->foto);
        }

        // Hapus pengurus dari database
        $pengurus->delete();
    }

    return response()->json(['success' => true, 'message' => 'Data pengurus berhasil dihapus.']);
    }


}
