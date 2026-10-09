<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (homepage) TEMPATIN.
     */
    public function index(): View
    {
        // Ambil data kos aktif dari database
        $featuredKos = Kos::where('status', 'active')->latest()->take(6)->get();

        return view('home.index', compact('featuredKos'));
    }

    /**
     * Tampilkan halaman tentang TEMPATIN.
     */
    public function about(): View
    {
        return view('owner.tentang');
    }
}
