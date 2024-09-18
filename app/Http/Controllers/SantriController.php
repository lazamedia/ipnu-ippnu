<?php

namespace App\Http\Controllers;

use App\Models\santri;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $santris = Santri::all(); // Mengambil semua data santri
        return view('dashboard.santri.index', compact('santris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.santri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nama_orangtua' => 'required|string|max:255',
            'rt' => 'required|string',
            'pesantren' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Lulus,Tidak Aktif',
        ]);

        santri::create($request->all());

        return response()->json(['success' => 'Santri berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $santri = Santri::findOrFail($id);
        return view('dashboard.santri.edit', compact('santri'));
    }

    public function update(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'nama_orangtua' => 'required|string|max:255',
            'rt' => 'required|string',
            'pesantren' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Lulus,Tidak Aktif',
        ]);

        $santri->update($request->all());

        return response()->json(['success' => 'Data santri berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $santri = Santri::findOrFail($id);
        $santri->delete();

        return response()->json(['success' => 'Data santri berhasil dihapus']);
    }

    public function bulkDelete(Request $request)
    {
    // Validasi bahwa request memiliki array ID
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:santri,id',
    ]);

    // Ambil daftar pengurus berdasarkan ID yang dikirim
    $santriList = Santri::whereIn('id', $request->ids)->get();

    foreach ($santriList as $santri) {

        // Hapus pengurus dari database
        $santri->delete();
    }

    return response()->json(['success' => true, 'message' => 'Data pengurus berhasil dihapus.']);
    }
}
