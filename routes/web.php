<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatsAppBotController;
use App\Http\Middleware\RoleMiddleware;



Route::get('/event/viewpdf', [PdfController::class, 'viewPDF'])->name('event.viewpdf');
Route::get('/event/downloadpdf', [PdfController::class, 'downloadPDF'])->name('event.downloadpdf');

// Controller Untuk Halaman HOME

Route::get('/', function () {
    return view('home',[
        "title" => "home",
        "active" => "home"
    ]);
});
Route::get('/test', function () {
    return view('test', [
        "title" => "test",
        "active" => "test" 
    ]);
});

// Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
//     Route::get('/test', function () {
//         return view('test', [
//             "title" => "test",
//             "active" => "test" 
//         ]);
//     });
// });

Route::get('/anggota', function () {
    return view('anggota',[
        "title" => "anggota",
        "active" => "anggota"
    ]);
});

Route::get('/profile', function () {
    return view('about',[
        "title" => "profile",
        "active" => "profile"
    ]);
});

Route::get('/forgot-password', function () {
    return view('login.forgot-password',[
        "title" => "Request Password",
        "active" => "forgot-password"
    ]);
});



// CONTROLLER DASHBOARD
Route::middleware(['auth', RoleMiddleware::class . ':admin,super_admin'])->group(function () {

    Route::get('/dashboard/test', function () {
        return view('dashboard.test', [
            "title" => "dashboard",
            "active" => "dashboard"
        ]);
    });

    Route::get('/dashboard', function () {
        return view('dashboard.home', [
            "title" => "dashboard",
            "active" => "dashboard"
        ]);
    });

    Route::get('/dashboard/makesta', function () {
        return view('dashboard.makesta.index', [
            "title" => "dashboard",
            "active" => "dashboard"
        ]);
    });


    Route::get('/dashboard/event/view', function () {
        return view('dashboard.event.view',[
            "title" => "dashboard/makesta",
            "active" => "dashboard/makesta"
        ]);
    });

    Route::resource('dashboard/pengurus', PengurusController::class);
    Route::post('dashboard/pengurus/bulk-delete', [PengurusController::class, 'bulkDelete'])->name('pengurus.bulk-delete');
    
    Route::resource('dashboard/santri', SantriController::class);
        
    Route::resource('dashboard/event', EventController::class);
    Route::post('/dashboard/event/bulk-delete', [EventController::class, 'bulkDelete'])->name('dashboard.event.bulk-delete');

    Route::post('/dashboard/auth/bulk-delete', [UserController::class, 'bulkDelete'])->name('auth.bulk-delete');
    Route::resource('/dashboard/auth', UserController::class);
    
});




// LOGIN LOGUOT
Route::get('/login', [LoginController::class, 'index' ] )->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate' ] );
Route::post('/logout', [LoginController::class, 'logout' ] );




