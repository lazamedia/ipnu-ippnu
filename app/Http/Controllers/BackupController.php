<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class BackupController extends Controller
{
    // Menampilkan halaman backup
    public function index()
    {
        return view('dashboard.backup.index');
    }

    // Fungsi untuk backup database
    public function backupDatabase()
    {
        // Mendapatkan detail koneksi database
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');

        // Membuat nama file backup
        $filename = "backup-" . date('Y-m-d_H-i-s') . ".sql";

        // Perintah untuk melakukan mysqldump
        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > " . storage_path("app/{$filename}");

        // Menjalankan perintah
        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            // Jika terjadi error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat backup.');
        }

        // Mengirim file backup untuk di-download
        $file = storage_path("app/{$filename}");
        if (File::exists($file)) {
            return Response::download($file)->deleteFileAfterSend(true);
        } else {
            return redirect()->back()->with('error', 'File backup tidak ditemukan.');
        }
    }

    // Fungsi untuk restore database dari file upload
    public function restoreDatabase(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file_dokumen' => 'required|mimes:sql'
        ]);

        // Mendapatkan file yang diupload
        $file = $request->file('file_dokumen');

        // Menyimpan file upload ke lokasi sementara
        $path = $file->storeAs('temp', 'restore.sql');

        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');

        // Perintah untuk merestore database
        $command = "mysql --user={$username} --password={$password} --host={$host} {$database} < " . storage_path("app/{$path}");

        // Menjalankan perintah
        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);

        // Menghapus file sementara
        Storage::delete($path);

        if ($returnVar !== 0) {
            // Jika terjadi error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat merestore database.');
        }

        return redirect()->back()->with('success', 'Database berhasil direstore.');
    }
}
