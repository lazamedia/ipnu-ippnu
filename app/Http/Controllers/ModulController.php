<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use Illuminate\Http\Request;

class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.modul.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function bulkDelete(Request $request)
    {
    // Validasi bahwa request memiliki array ID
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:modul,id',
    ]);

    // Ambil daftar pengurus berdasarkan ID yang dikirim
    $modulList = Modul::whereIn('id', $request->ids)->get();

    foreach ($modulList as $modul) {

        // Hapus pengurus dari database
        $modul->delete();
    }

    return response()->json(['success' => true, 'message' => 'Data pengurus berhasil dihapus.']);
    }

}
