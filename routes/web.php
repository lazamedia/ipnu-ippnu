<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\ApiPengurusController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\PostControler;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewAnggotaController;
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
Route::middleware(['auth:sanctum', RoleMiddleware::class . ':admin,super_admin'])->group(function () {

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
    Route::post('dashboard/santri/bulk-delete', [SantriController::class, 'bulkDelete'])->name('santri.bulk-delete');
        
    Route::resource('dashboard/event', EventController::class);
    Route::post('/dashboard/event/bulk-delete', [EventController::class, 'bulkDelete'])->name('dashboard.event.bulk-delete');

    Route::post('/dashboard/auth/bulk-delete', [UserController::class, 'bulkDelete'])->name('auth.bulk-delete');
    Route::resource('/dashboard/auth', UserController::class);

    route::resource('dashboard/artikel' , ArtikelController::class);

    route::resource('dashboard/modul' , ModulController::class);
    route::post('dashboard/modul/bulk-delete' , [ModulController::class, 'bulkDelete'])->name('modul.bulk-delete');
    
});

Route::get('/posts', [PostControler::class, 'index']);
Route::get('posts/{post:slug}', [PostControler::class, 'show']);
Route::resource('/dashboard/posts', DashboardPostController::class )->middleware('auth');
Route::get('/dashboard/posts/checkSlug', [ DashboardPostController::class, 'checkSlug'])->middleware('auth');
Route::post('dashboard/posts/bulk-delete', [DashboardPostController::class, 'bulkDelete'])->name('posts.bulk-delete');


Route::post('dashboard/categories/bulk-delete', [AdminCategoryController::class, 'bulkDelete'])->name('category.bulk-delete');

Route::get('/dashboard/categories/checkSlug', [ AdminCategoryController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/categories', AdminCategoryController::class)->middleware('auth');
Route::put('dashboard/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
Route::delete('dashboard/categories}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');



// LOGIN LOGUOT
Route::get('/login', [LoginController::class, 'index' ] )->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate' ] );
Route::post('/logout', [LoginController::class, 'logout' ] );


Route::prefix('api')->group(function () {
    Route::get('/pengurus', [ApiPengurusController::class, 'index']);
});


Route::get('anggota', [ViewAnggotaController::class, 'index']);