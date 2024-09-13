<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return view('dashboard.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penguruses = Pengurus::all();

        return view('dashboard.event.create', compact('penguruses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Set locale ke Indonesia untuk penamaan bulan
        \Carbon\Carbon::setLocale('id');
    
        // Validasi data input
        $validatedData = $request->validate([
            'ketua_pelaksana' => 'required|string|max:255',
            'nama_event' => 'required|string|max:255',
            'sekretaris' => 'required|string|max:255',
            'bendahara' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'anggaran' => 'required|numeric',
            'tanggal' => 'required|date',
            'tamu_undangan' => 'nullable|array',
            'divisi_humas' => 'nullable|array',
            'divisi_acara' => 'nullable|array',
            'divisi_perkap' => 'nullable|array',
            'divisi_dekdok' => 'nullable|array',
            'divisi_konsumsi' => 'nullable|array',
            'keperluan_divisi' => 'nullable|array',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_dokumen' => 'nullable|mimes:doc,docx,xls,xlsx,pdf,ppt,pptx|max:2048',
        ]);
    
        // Konversi array menjadi string menggunakan implode
        $validatedData['tamu_undangan'] = is_array($request->tamu_undangan) ? implode(', ', $request->tamu_undangan) : null;
        $validatedData['divisi_humas'] = is_array($request->divisi_humas) ? implode(', ', $request->divisi_humas) : null;
        $validatedData['divisi_acara'] = is_array($request->divisi_acara) ? implode(', ', $request->divisi_acara) : null;
        $validatedData['divisi_perkap'] = is_array($request->divisi_perkap) ? implode(', ', $request->divisi_perkap) : null;
        $validatedData['divisi_dekdok'] = is_array($request->divisi_dekdok) ? implode(', ', $request->divisi_dekdok) : null;
        $validatedData['divisi_konsumsi'] = is_array($request->divisi_konsumsi) ? implode(', ', $request->divisi_konsumsi) : null;
        $validatedData['keperluan_divisi'] = is_array($request->keperluan_divisi) ? implode(', ', $request->keperluan_divisi) : null;
    
        // Format tanggal agar menyimpan dengan nama bulan dan format 24 jam
        $validatedData['tanggal'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->tanggal)
                                    ->translatedFormat('d F Y H:i'); // Format dengan nama bulan dan waktu 24 jam
    
        // Menyimpan file foto jika ada
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('public/foto'); // Simpan di storage/public/foto
            $validatedData['foto'] = $fotoPath;
        }
    
        // Menyimpan file dokumen jika ada
        if ($request->hasFile('file_dokumen')) {
            $dokumenPath = $request->file('file_dokumen')->store('public/dokumen'); // Simpan di storage/public/dokumen
            $validatedData['file_dokumen'] = $dokumenPath;
        }
    
        // Simpan data ke dalam database
        Event::create($validatedData);
    
        return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan');
    }
    

    


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $event = Event::findOrFail($id); // Mencari event berdasarkan ID
    $penguruses = Pengurus::all(); // Mengambil data pengurus

    // Mengirimkan data event dan pengurus ke view edit
    return view('dashboard.event.edit', compact('event', 'penguruses'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);

    // Validasi input
    $validated = $request->validate([
        'ketua_pelaksana' => 'required|string|max:255',
        'nama_event' => 'required|string|max:255',
        'sekretaris' => 'required|string|max:255',
        'bendahara' => 'required|string|max:255',
        'tempat' => 'required|string|max:255',
        'anggaran' => 'required|numeric',
        'tanggal' => 'required|date',
        'tamu_undangan' => 'nullable|array',
        'divisi_humas' => 'nullable|array',
        'divisi_acara' => 'nullable|array',
        'divisi_perkap' => 'nullable|array',
        'divisi_dekdok' => 'nullable|array',
        'divisi_konsumsi' => 'nullable|array',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'file_dokumen' => 'nullable|mimes:doc,docx,xls,xlsx,pdf,ppt,pptx|max:2048',
    ]);

    // Konversi array menjadi string menggunakan implode
    $validated['tamu_undangan'] = is_array($request->tamu_undangan) ? implode(', ', $request->tamu_undangan) : null;
    $validated['divisi_humas'] = is_array($request->divisi_humas) ? implode(', ', $request->divisi_humas) : null;
    $validated['divisi_acara'] = is_array($request->divisi_acara) ? implode(', ', $request->divisi_acara) : null;
    $validated['divisi_perkap'] = is_array($request->divisi_perkap) ? implode(', ', $request->divisi_perkap) : null;
    $validated['divisi_dekdok'] = is_array($request->divisi_dekdok) ? implode(', ', $request->divisi_dekdok) : null;
    $validated['divisi_konsumsi'] = is_array($request->divisi_konsumsi) ? implode(', ', $request->divisi_konsumsi) : null;

    // Format tanggal
    $validated['tanggal'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->tanggal)
                              ->translatedFormat('d F Y H:i');

    // Cek dan simpan file foto jika ada
    if ($request->hasFile('foto')) {
        if ($event->foto) {
            Storage::disk('public')->delete($event->foto);
        }
        $fotoPath = $request->file('foto')->store('public/foto');
        $validated['foto'] = $fotoPath;
    }

    // Cek dan simpan file dokumen jika ada
    if ($request->hasFile('file_dokumen')) {
        if ($event->file_dokumen) {
            Storage::disk('public')->delete($event->file_dokumen);
        }
        $dokumenPath = $request->file('file_dokumen')->store('public/dokumen');
        $validated['file_dokumen'] = $dokumenPath;
    }

    // Update data event
    $event->update($validated);

    return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // Hapus file dokumen dari storage jika ada
        if ($event->file_dokumen) {
            Storage::disk('public')->delete($event->file_dokumen);
        }

        // Hapus data event dari database
        $event->delete();

        return redirect()->route('event.index')->with('success', 'Event deleted successfully.');
    }

    /**
     * Handle bulk delete action.
     */
    public function bulkDelete(Request $request)
    {
        $eventIds = $request->ids;

        try {
            $events = Event::whereIn('id', $eventIds)->get();

            foreach ($events as $event) {
                if ($event->file_dokumen) {
                    Storage::disk('public')->delete($event->file_dokumen);
                }
                $event->delete();
            }

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
