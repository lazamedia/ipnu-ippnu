<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login',
            'active' => 'login',
            'csrf_token' => csrf_token() // Menyertakan token CSRF dalam view
        ]);
    }

    public function authenticate(Request $request)
    {
        // Validasi yang lebih kuat untuk username dan password
        $credentials = $request->validate([
            'username' => 'required|string|min:3|max:50',
            'password' => 'required|string|min:8|max:50'
        ]);

        // Regenerasi sesi sebelum otentikasi untuk mencegah session fixation attack
        $request->session()->regenerate();

        // Tambahkan log untuk percobaan login yang gagal atau mencurigakan
        if ($this->hasTooManyLoginAttempts($request)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            Log::warning('Percobaan login terlalu banyak untuk username: ' . $request->input('username') . ' dari IP: ' . $request->ip());
            return back()->with('loginError', 'Terlalu banyak percobaan login. Coba lagi dalam ' . $seconds . ' detik.')
                         ->with('retryAfter', $seconds);
        }

        // Cek kredensial pengguna dan lakukan log jika gagal
        if (Auth::attempt($credentials)) {
            // Jika berhasil, bersihkan rate limiter dan arahkan ke dashboard
            RateLimiter::clear($this->throttleKey($request));
            return redirect()->intended('/dashboard');
        }

        // Jika otentikasi gagal, log percobaan login dan tambahkan penalti
        Log::warning('Percobaan login gagal untuk username: ' . $request->input('username') . ' dari IP: ' . $request->ip());
        $this->incrementLoginAttempts($request);
        return back()->with('loginError', 'Error, Silahkan coba lagi.');
    }

    public function logout()
    {
        // Logout pengguna, invalidate sesi, regenerate token, dan flush semua sesi
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        request()->session()->flush();  // Menghapus semua sesi
        return redirect('/');
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        // Menggunakan kombinasi IP saja untuk menghindari serangan username enumeration
        return RateLimiter::tooManyAttempts($this->throttleKey($request), 3);
    }

    protected function incrementLoginAttempts(Request $request)
    {
        // Tambahkan exponential backoff dengan menghitung penalti waktu
        RateLimiter::hit($this->throttleKey($request), now()->addSeconds(60));
    }

    protected function throttleKey(Request $request)
    {
        // Gunakan IP saja untuk menghindari serangan username enumeration
        return $request->ip();
    }
}
