<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
        return view('dashboard.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
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
        $event = Event::findOrFail($id);
        return view('dashboard.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama_event' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required',
            'link_drive' => 'required|url',
            'file_dokumen' => 'nullable|mimes:pdf|max:5048',
        ]);

        // Cek jika file dokumen baru diupload
        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada
            if ($event->file_dokumen) {
                Storage::disk('public')->delete($event->file_dokumen);
            }

            // Simpan file baru
            $filePath = $request->file('file_dokumen')->storeAs('documents', uniqid().'.'.$request->file('file_dokumen')->getClientOriginalExtension(), 'public');
            $validated['file_dokumen'] = $filePath;
        }

        // Update data di database
        $event->update($validated);

        return redirect()->route('dashboard.event.index')->with('success', 'Event updated successfully.');
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
