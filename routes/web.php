<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerKosController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OwnerKosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - TEMPATIN
|--------------------------------------------------------------------------
*/

// Homepage & Informasi Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::view('/kontak', 'contact.index')->name('contact');
Route::view('/artikel', 'artikel.index')->name('artikel');
Route::view('/promo', 'promo.index')->name('promo');

// Pencarian Kos Umum
Route::redirect('/search', '/kos')->name('search.kos');
Route::get('/kos', [KosController::class, 'index'])->name('kos.index');
Route::prefix('kos')->name('kos.')->group(function () {
    Route::get('/{slug}', [KosController::class, 'show'])->name('show');
});
Route::post('/favorit/toggle', [MemberController::class, 'toggleFavorit'])->name('kos.favorit.toggle');

// Autentikasi (Hanya untuk Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    
    // Google OAuth (Login & Register)
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// Logout Global
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Area Owner (Membutuhkan Autentikasi dan Role Owner)
Route::prefix('owner')->name('owner.')->middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/', [OwnerKosController::class, 'dashboard'])->name('dashboard');
    Route::get('/notifikasi', [OwnerKosController::class, 'notifikasi'])->name('notifikasi');
    Route::get('/statistik', [OwnerKosController::class, 'statistik'])->name('statistik');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('kos')->name('kos.')->group(function () {
        Route::get('/', [OwnerKosController::class, 'index'])->name('index');
        Route::get('/my', [OwnerKosController::class, 'myKos'])->name('my');
        Route::get('/manage', [OwnerKosController::class, 'manage'])->name('manage');
        Route::get('/penilaian', [OwnerKosController::class, 'penilaian'])->name('penilaian');
        Route::get('/create', [OwnerKosController::class, 'create'])->name('create');
        Route::post('/store', [OwnerKosController::class, 'store'])->name('store');
        Route::get('/{kos:slug}/edit', [OwnerKosController::class, 'edit'])->name('edit');
        Route::put('/{kos:slug}/update', [OwnerKosController::class, 'update'])->name('update');
        Route::delete('/{kos:slug}', [OwnerKosController::class, 'destroy'])->name('destroy');
        Route::get('/{kos:slug}', [OwnerKosController::class, 'show'])->name('show');
    });
});

// Area Customer (Legacy - Membutuhkan Autentikasi dan Role Customer)
Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:customer'])->group(function () {
    Route::prefix('kos')->name('kos.')->group(function () {
        Route::get('/', [CustomerKosController::class, 'index'])->name('index');
    });

    Route::prefix('invoice')->name('invoice.')->group(function () {
        Route::get('/', [CustomerKosController::class, 'invoice'])->name('index');
    });
});

// Area Member (Membutuhkan Autentikasi dan Role Customer)
Route::prefix('member')->name('member.')->middleware(['auth', 'role:customer'])->group(function () {
    // Member area - mirror public pages under /member
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/tentang', [HomeController::class, 'about'])->name('about');
    Route::view('/kontak', 'contact.index')->name('contact');
    Route::view('/artikel', 'artikel.index')->name('artikel');
    Route::view('/promo', 'promo.index')->name('promo');

    // Pencarian Kos Umum untuk member area
    Route::redirect('/search', '/member/kos')->name('search.kos');
    Route::get('/kos', [KosController::class, 'index'])->name('kos.index');
    Route::prefix('kos')->name('kos.')->group(function () {
        Route::get('/{slug}', [KosController::class, 'show'])->name('show');
    });
    Route::get('/pesan', function () {
        return view('member.message.index');
    })->name('pesan');
    Route::get('/chat', function () {
        return redirect()->route('member.pesan');
    })->name('chat');
    Route::get('/favorit', [MemberController::class, 'favorit'])->name('favorit');
    Route::post('/favorit/toggle', [MemberController::class, 'toggleFavorit'])->name('favorit.toggle');
    Route::get('/booking/{slug}', [MemberController::class, 'booking'])->name('booking.create');
    Route::post('/booking/{slug}', [MemberController::class, 'store'])->name('booking.store');
    Route::get('/booking/detail/{booking_code}', [MemberController::class, 'show'])->name('booking.show');
    Route::post('/booking/{slug}/payment', [MemberController::class, 'payment'])->name('booking.payment');
    Route::post('/payment/confirm', [MemberController::class, 'confirmPayment'])->name('payment.confirm');
    Route::get('/profil', [MemberController::class, 'profile'])->name('profile');
    Route::put('/profil', [MemberController::class, 'updateProfile'])->name('profile.update');
    Route::get('/notifikasi', [MemberController::class, 'notifikasi'])->name('notifikasi');
    Route::prefix('invoice')->name('invoice.')->group(function () {
        Route::get('/', [MemberController::class, 'invoice'])->name('index');
        Route::get('/{nomor_invoice}', [MemberController::class, 'invoiceDetail'])->name('show');
    });
    // Logout for member area
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
