<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KosController extends Controller
{
    /**
     * Halaman daftar kos publik.
     * Hanya menampilkan kos yang berstatus active dan tidak di-soft-delete.
     */
    public function index(Request $request): View
    {
        $query = Kos::query()->where('status', 'active');

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('city', 'like', "%{$keyword}%")
                    ->orWhere('address', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        $listKos = $query->latest()->get();

        return view('kos.index', compact('listKos'));
    }

    /**
     * Halaman detail kos publik berdasarkan slug.
     * Mengembalikan 404 jika slug tidak ditemukan, status inactive, atau soft-deleted.
     */
    public function show(string $slug): View
    {
        $kos = Kos::with(['owner', 'facilities', 'photos', 'reviews' => function ($q) {
            $q->latest();
        }, 'reviews.user'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Properti kos serupa (aktif, tidak soft-deleted, dan exclude kos saat ini)
        $similarKos = Kos::where('status', 'active')
            ->where('id', '!=', $kos->id)
            ->latest()
            ->take(3)
            ->get();

        return view('kos.show', compact('kos', 'similarKos'));
    }

    /**
     * Simpan ulasan penghuni baru untuk properti kos ini.
     * Ulasan ini langsung tersimpan dan dapat dilihat oleh pemilik kos di akun owner.
     */
    public function storeReview(Request $request, string $slug): RedirectResponse
    {
        $kos = Kos::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $validated = $request->validate([
            'reviewer_name' => ['required', 'string', 'max:100'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'reviewer_name.required' => 'Nama penghuni wajib diisi.',
            'rating.required' => 'Silakan pilih skor bintang ulasan (1 - 5).',
            'rating.between' => 'Rating harus antara 1 sampai 5 bintang.',
            'comment.required' => 'Tuliskan ulasan pengalaman Anda.',
            'comment.min' => 'Ulasan minimal 5 karakter.',
        ]);

        $validated['kos_id'] = $kos->id;
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
            if (empty($validated['reviewer_name'])) {
                $validated['reviewer_name'] = auth()->user()->name;
            }
        }

        Review::create($validated);

        return redirect()->to(url()->previous() . '#reviews')
            ->with('review_success', 'Terima kasih! Ulasan Anda berhasil dikirim dan tersimpan di akun pemilik kos.');
    }
}
