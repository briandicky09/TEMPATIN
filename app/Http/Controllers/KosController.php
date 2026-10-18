<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Kos;
use App\Models\Review;
use App\Notifications\TempatinNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KosController extends Controller
{
    /**
     * Halaman daftar kos publik.
     * Hanya menampilkan kos yang berstatus active dan tidak di-soft-delete.
     */
    public function index(Request $request): View
    {
        $query = Kos::query()->where('status', 'active')
            ->with(['facilities', 'photos', 'owner'])
            ->withAvg('reviews', 'rating');

        if ($request->filled('keyword')) {
            $keyword = trim($request->input('keyword'));
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
            $query->where('city', 'like', '%' . trim($request->input('city')) . '%');
        }

        if ($request->filled('min_price') && is_numeric($request->input('min_price'))) {
            $minPrice = max(0, (float) $request->input('min_price'));
            $query->where('price', '>=', $minPrice);
        }

        if ($request->filled('max_price') && is_numeric($request->input('max_price'))) {
            $maxPrice = (float) $request->input('max_price');
            if ($maxPrice > 0) {
                $query->where('price', '<=', $maxPrice);
            }
        }

        if ($request->filled('facilities')) {
            $facilityIds = (array) $request->input('facilities');
            $query->whereHas('facilities', function ($q) use ($facilityIds) {
                $q->whereIn('facilities.id', $facilityIds);
            });
        }

        $sort = $request->input('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'rating_desc' => $query->orderByDesc('reviews_avg_rating'),
            default => $query->latest('id'),
        };

        $listKos = $query->paginate(9)->withQueryString();
        $facilities = Facility::orderBy('name')->get();

        return view('kos.index', compact('listKos', 'facilities'));
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
     * Hanya dapat dilakukan oleh penghuni terverifikasi dengan riwayat booking confirmed/active/completed.
     */
    public function storeReview(Request $request, string $slug): RedirectResponse
    {
        $kos = Kos::where('slug', $slug)->where('status', 'active')->firstOrFail();

        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan masuk terlebih dahulu untuk memberikan ulasan.');
        }

        $user = Auth::user();

        // 1. Cek apakah user memiliki riwayat sewa yang sah untuk kos ini
        $qualifyingBooking = Booking::where('kos_id', $kos->id)
            ->where('customer_id', $user->id)
            ->whereIn('status', ['confirmed', 'active', 'completed'])
            ->latest('id')
            ->first();

        if (!$qualifyingBooking) {
            return redirect()->to(url()->previous() . '#reviews')
                ->with('review_error', 'Hanya penghuni terverifikasi dengan riwayat sewa terkonfirmasi yang dapat memberikan ulasan untuk kos ini.');
        }

        // 2. Cegah ulasan ganda untuk kos yang sama
        $alreadyReviewed = Review::where('kos_id', $kos->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->to(url()->previous() . '#reviews')
                ->with('review_error', 'Anda sudah memberikan ulasan untuk properti kos ini.');
        }

        // 3. Validasi input
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'rating.required' => 'Silakan pilih skor bintang ulasan (1 - 5).',
            'rating.between' => 'Rating harus antara 1 sampai 5 bintang.',
            'comment.required' => 'Tuliskan ulasan pengalaman Anda.',
            'comment.min' => 'Ulasan minimal 5 karakter.',
            'comment.max' => 'Ulasan maksimal 1000 karakter.',
        ]);

        $review = Review::create([
            'kos_id' => $kos->id,
            'user_id' => $user->id,
            'booking_id' => $qualifyingBooking->id,
            'reviewer_name' => $user->name,
            'is_verified_tenant' => true,
            'rating' => (int) $validated['rating'],
            'comment' => strip_tags($validated['comment']),
        ]);

        // Kirim notifikasi ke pemilik kos
        try {
            $kos->owner?->notify(new TempatinNotification(
                'Ulasan Penghuni Baru',
                $user->name . ' memberikan ulasan ' . $review->rating . ' bintang untuk ' . $kos->title . '.',
                route('owner.kos.penilaian'),
                'review',
                'fa-star'
            ));
        } catch (\Throwable $e) {
            // Abaikan jika notifikasi background gagal
        }

        return redirect()->to(url()->previous() . '#reviews')
            ->with('review_success', 'Terima kasih! Ulasan Anda sebagai penghuni terverifikasi berhasil dikirim.');
    }
}
