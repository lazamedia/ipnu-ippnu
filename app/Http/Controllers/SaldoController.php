<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaldoController extends Controller
{
    public function index()
{
    // Mengambil semua data saldo dan urutkan berdasarkan tanggal
    $saldoData = Saldo::orderBy('tanggal', 'asc')->get();

    // Inisialisasi variabel
    $total_pemasukan = 0;
    $total_pengeluaran = 0;
    $saldo_terakhir = 0;

    // Variabel untuk menyimpan data saldo yang akan digunakan di view
    $saldoKumulatif = [];

    // Perhitungan total pemasukan, pengeluaran, dan saldo terakhir per transaksi
    foreach ($saldoData as $saldo) {
        if ($saldo->tipe_transaksi == 'pemasukan') {
            $total_pemasukan += $saldo->pemasukan;
            $saldo_terakhir += $saldo->pemasukan;
        } elseif ($saldo->tipe_transaksi == 'pengeluaran') {
            $total_pengeluaran += $saldo->pengeluaran;
            $saldo_terakhir -= $saldo->pengeluaran;
        }

        // Masukkan saldo kumulatif untuk transaksi ini
        $saldoKumulatif[] = [
            'id' => $saldo->id,
            'nama_transaksi' => $saldo->nama_transaksi,
            'tanggal' => $saldo->tanggal,
            'pemasukan' => $saldo->pemasukan,
            'pengeluaran' => $saldo->pengeluaran,
            'saldo_terakhir' => $saldo_terakhir
        ];
    }

    // Kirim data ke view
    return view('dashboard.saldo.index', [
        'saldo' => $saldoKumulatif,
        'total_pemasukan' => $total_pemasukan,
        'total_pengeluaran' => $total_pengeluaran,
        'sisa_saldo' => $saldo_terakhir // Saldo akhir atau saldo sisa
    ]);
}

    

    public function create()
    {
        return view('dashboard.saldo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_transaksi' => 'required',
            'tipe_transaksi' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file upload jika ada
        $filePath = null;
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('bukti_transaksi', 'public');
        }

        // Inisialisasi nilai pemasukan dan pengeluaran
        $pemasukan = 0;
        $pengeluaran = 0;

        // Cek tipe transaksi dan masukkan ke kolom yang sesuai
        if ($request->tipe_transaksi == 'pemasukan') {
            $pemasukan = $request->jumlah;
        } elseif ($request->tipe_transaksi == 'pengeluaran') {
            $pengeluaran = $request->jumlah;
        }

        Saldo::create([
            'nama_transaksi' => $request->nama_transaksi,
            'tipe_transaksi' => $request->tipe_transaksi,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'image' => $filePath,
            'tanggal' => $request->tanggal,

        ]);

        return redirect()->route('saldo.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $saldo = Saldo::findOrFail($id);
        return view('dashboard.saldo.edit', compact('saldo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_transaksi' => 'required',
            'tipe_transaksi' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $saldo = Saldo::findOrFail($id);
        
        $filePath = $saldo->image;

        // Hapus gambar lama jika ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('image')->store('bukti_transaksi', 'public');
        }

        // Inisialisasi nilai pemasukan dan pengeluaran
        $pemasukan = 0;
        $pengeluaran = 0;

        // Cek tipe transaksi dan masukkan ke kolom yang sesuai
        if ($request->tipe_transaksi == 'pemasukan') {
            $pemasukan = $request->jumlah;
        } elseif ($request->tipe_transaksi == 'pengeluaran') {
            $pengeluaran = $request->jumlah;
        }

        $saldo->update([
            'nama_transaksi' => $request->nama_transaksi,
            'tipe_transaksi' => $request->tipe_transaksi,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'image' => $filePath,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('saldo.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $saldo = Saldo::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($saldo->bukti_transaksi) {
            Storage::disk('public')->delete($saldo->bukti_transaksi);
        }

        $saldo->delete();

        return redirect()->route('saldo.index')->with('success', 'Transaksi berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:saldo,id',
        ]);

        $saldos = Saldo::whereIn('id', $request->ids)->get();

        // Hapus semua gambar yang terkait
        foreach ($saldos as $saldo) {
            if ($saldo->bukti_transaksi) {
                Storage::disk('public')->delete($saldo->bukti_transaksi);
            }
            $saldo->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi terpilih berhasil dihapus',
        ]);
    }
}