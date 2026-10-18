<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CustomerKosController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\MaintenanceReportController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MidtransNotificationController;
use App\Http\Controllers\OwnerBookingController;
use App\Http\Controllers\OwnerKosController;
use App\Http\Controllers\OwnerRoomController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RentalContractController;
use App\Http\Controllers\SurveyController;
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
    Route::post('/{slug}/review', [KosController::class, 'storeReview'])->name('review.store');
});
Route::post('/favorit/toggle', [MemberController::class, 'toggleFavorit'])->name('kos.favorit.toggle');
Route::post('/kos/{slug}/survey', [SurveyController::class, 'store'])->name('surveys.store');

// Autentikasi (Hanya untuk Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    // Password Reset
    Route::get('/lupa-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/lupa-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
    
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

    // Manajemen Pemesanan Masuk & Persetujuan Sewa
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [OwnerBookingController::class, 'index'])->name('index');
        Route::get('/{booking_code}', [OwnerBookingController::class, 'show'])->name('show');
        Route::post('/{booking_code}/approve', [OwnerBookingController::class, 'approve'])->name('approve');
        Route::post('/{booking_code}/reject', [OwnerBookingController::class, 'reject'])->name('reject');
        Route::post('/{booking_code}/checkin', [OwnerBookingController::class, 'checkin'])->name('checkin');
        Route::post('/{booking_code}/checkout', [OwnerBookingController::class, 'checkout'])->name('checkout');
    });

    Route::prefix('kos')->name('kos.')->group(function () {
        Route::get('/', [OwnerKosController::class, 'index'])->name('index');
        Route::get('/my', [OwnerKosController::class, 'myKos'])->name('my');
        Route::get('/manage', [OwnerKosController::class, 'manage'])->name('manage');
        Route::get('/penilaian', [OwnerKosController::class, 'penilaian'])->name('penilaian');
        Route::post('/reviews/{review}/reply', [OwnerKosController::class, 'replyReview'])->name('reviews.reply');
        Route::get('/create', [OwnerKosController::class, 'create'])->name('create');
        Route::post('/store', [OwnerKosController::class, 'store'])->name('store');
        Route::get('/{kos:slug}/edit', [OwnerKosController::class, 'edit'])->name('edit');
        Route::put('/{kos:slug}/update', [OwnerKosController::class, 'update'])->name('update');
        Route::delete('/{kos:slug}', [OwnerKosController::class, 'destroy'])->name('destroy');
        Route::get('/{kos:slug}', [OwnerKosController::class, 'show'])->name('show');
        
        // Inventaris Kamar Individual
        Route::get('/{kos:slug}/rooms', [OwnerRoomController::class, 'index'])->name('rooms.index');
        Route::post('/{kos:slug}/rooms', [OwnerRoomController::class, 'store'])->name('rooms.store');
        Route::put('/{kos:slug}/rooms/{room}', [OwnerRoomController::class, 'update'])->name('rooms.update');
        Route::delete('/{kos:slug}/rooms/{room}', [OwnerRoomController::class, 'destroy'])->name('rooms.destroy');
    });

    // Jadwal Survei Masuk
    Route::prefix('survei')->name('surveys.')->group(function () {
        Route::get('/', [SurveyController::class, 'ownerIndex'])->name('index');
        Route::patch('/{survey}/status', [SurveyController::class, 'ownerUpdateStatus'])->name('updateStatus');
    });

    // Daftar Penghuni Aktif & Siklus Sewa
    Route::get('/penghuni', [OwnerKosController::class, 'penghuni'])->name('penghuni.index');

    // Laporan Kerusakan Properti
    Route::prefix('laporan-kerusakan')->name('maintenance.')->group(function () {
        Route::get('/', [MaintenanceReportController::class, 'ownerIndex'])->name('index');
        Route::patch('/{report}/status', [MaintenanceReportController::class, 'ownerUpdateStatus'])->name('updateStatus');
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

// Midtrans Webhook Notification (Server-to-Server, CSRF Exempt)
Route::post('/payment/midtrans/notification', [MidtransNotificationController::class, 'handle'])->name('midtrans.notification');

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
        Route::post('/{slug}/review', [KosController::class, 'storeReview'])->name('review.store');
    });
    Route::get('/pesan', [ChatController::class, 'index'])->name('pesan');
    Route::get('/chat', function () {
        return redirect()->route('chat.index');
    })->name('chat');
    Route::get('/favorit', [MemberController::class, 'favorit'])->name('favorit');
    Route::post('/favorit/toggle', [MemberController::class, 'toggleFavorit'])->name('favorit.toggle');
    Route::get('/booking/{slug}', [MemberController::class, 'booking'])->name('booking.create');
    Route::post('/booking/{slug}', [MemberController::class, 'store'])->name('booking.store');
    Route::get('/booking/detail/{booking_code}', [MemberController::class, 'show'])->name('booking.show');
    Route::get('/booking/nota/{booking_code}/download', [MemberController::class, 'downloadNota'])->name('booking.nota.pdf');
    Route::match(['get', 'post'], '/booking/{slug}/payment', [MemberController::class, 'payment'])->name('booking.payment');
    Route::post('/payment/confirm', [MemberController::class, 'confirmPayment'])->name('payment.confirm');
    Route::get('/profil', [MemberController::class, 'profile'])->name('profile');
    Route::put('/profil', [MemberController::class, 'updateProfile'])->name('profile.update');
    Route::get('/notifikasi', [MemberController::class, 'notifikasi'])->name('notifikasi');
    Route::prefix('invoice')->name('invoice.')->group(function () {
        Route::get('/', [MemberController::class, 'invoice'])->name('index');
        Route::get('/{nomor_invoice}', [MemberController::class, 'invoiceDetail'])->name('show');
    });
    // Jadwal Survei Member
    Route::prefix('survei')->name('surveys.')->group(function () {
        Route::get('/', [SurveyController::class, 'customerIndex'])->name('index');
        Route::patch('/{survey}/cancel', [SurveyController::class, 'customerCancel'])->name('cancel');
    });
    // Laporan Kerusakan Kamar
    Route::prefix('laporan-kerusakan')->name('maintenance.')->group(function () {
        Route::get('/', [MaintenanceReportController::class, 'customerIndex'])->name('index');
        Route::get('/create', [MaintenanceReportController::class, 'create'])->name('create');
        Route::post('/', [MaintenanceReportController::class, 'store'])->name('store');
    });
    // Logout for member area
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Chat & Komunikasi Internal (Customer & Owner)
Route::middleware('auth')->prefix('pesan')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');
    Route::post('/{conversation}/send', [ChatController::class, 'sendMessage'])->name('send');
    Route::post('/kos/{kos:slug}/start', [ChatController::class, 'start'])->name('start');
});

// Kontrak Sewa Digital
Route::middleware('auth')->prefix('kontrak')->name('contracts.')->group(function () {
    Route::get('/booking/{booking_code}', [RentalContractController::class, 'forBooking'])->name('forBooking');
    Route::get('/{contract_number}', [RentalContractController::class, 'show'])->name('show');
    Route::post('/{contract_number}/sign', [RentalContractController::class, 'sign'])->name('sign');
    Route::get('/{contract_number}/pdf', [RentalContractController::class, 'downloadPdf'])->name('pdf');
});

// Area Superadmin Platform
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/kos', [AdminController::class, 'kosIndex'])->name('kos.index');
    Route::patch('/kos/{kos:slug}/status', [AdminController::class, 'kosUpdateStatus'])->name('kos.updateStatus');
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/bookings', [AdminController::class, 'bookingsIndex'])->name('bookings.index');
    Route::get('/reviews', [AdminController::class, 'reviewsIndex'])->name('reviews.index');
    Route::delete('/reviews/{review}', [AdminController::class, 'destroyReview'])->name('reviews.destroy');
});
