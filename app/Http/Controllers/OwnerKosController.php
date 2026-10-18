<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKosRequest;
use App\Http\Requests\UpdateKosRequest;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Invoice;
use App\Models\Kos;
use App\Models\Review;
use App\Models\Room;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OwnerKosController extends Controller
{
    use AuthorizesRequests;

    /**
     * Dashboard owner.
     */
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $listKos = $user->kos()->latest()->get();
        $totalKos = $listKos->count();
        $kosAktif = $listKos->where('status', 'active')->count();
        $kosNonaktif = $listKos->where('status', 'inactive')->count();
        $rataHarga = (int) round($listKos->avg('price') ?? 0);
        $recentKos = $listKos->take(3);

        return view('owner.dashboard', compact('totalKos', 'kosAktif', 'kosNonaktif', 'rataHarga', 'recentKos'));
    }

    /**
     * Halaman daftar kos milik owner.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Kos::class);
        $listKos = $request->user()->kos()->latest()->get();

        return view('owner.kos.index', compact('listKos'));
    }

    /**
     * Form tambah kos baru.
     */
    public function create(): View
    {
        $this->authorize('create', Kos::class);
        $facilities = Facility::orderBy('name')->get();

        return view('owner.kos.create', compact('facilities'));
    }

    /**
     * Simpan kos baru milik owner yang sedang login.
     * owner_id otomatis di-inject dari authenticated user (server-side).
     */
    public function store(StoreKosRequest $request): RedirectResponse
    {
        // Otorisasi dicek di StoreKosRequest & KosPolicy::create
        $validated = $request->validated();

        // Mencegah manipulasi owner_id dari frontend
        unset($validated['owner_id']);

        // Pisahkan facilities dan photos dari data tabel kos
        $facilityIds = $validated['facilities'] ?? [];
        unset($validated['facilities']);
        unset($validated['photos']);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Pastikan slug unik (termasuk cek soft-deleted records)
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Kos::withTrashed()->where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('kos', 'public');
            $validated['thumbnail'] = 'storage/' . $path;
        } else {
            $validated['thumbnail'] = 'assets/img/kos/1.png';
        }

        $validated['status'] = 'active';

        $newUploadedFiles = [];
        DB::beginTransaction();
        try {
            // Simpan kos dengan owner_id mutlak dari user yang sedang login
            $kos = $request->user()->kos()->create($validated);

            // Sinkronisasi relasi fasilitas
            $kos->facilities()->sync($facilityIds);

            // Simpan banyak foto galeri jika ada
            if ($request->hasFile('photos')) {
                $sortOrder = 1;
                foreach ($request->file('photos') as $file) {
                    $photoPath = $file->store('kos/photos', 'public');
                    $newUploadedFiles[] = $photoPath;

                    $kos->photos()->create([
                        'photo_path' => $photoPath,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            // Bersihkan file yang baru diupload jika transaksi database gagal
            foreach ($newUploadedFiles as $filePath) {
                Storage::disk('public')->delete($filePath);
            }
            throw $e;
        }

        return redirect()->route('owner.kos.my')->with('success', 'Kos berhasil ditambahkan.');
    }

    /**
     * Halaman Kos Saya untuk owner.
     */
    public function myKos(Request $request): View
    {
        $this->authorize('viewAny', Kos::class);
        $listKos = $request->user()->kos()->latest()->get();

        return view('owner.kos.my', compact('listKos'));
    }

    /**
     * Halaman manajemen kos untuk owner.
     */
    public function manage(Request $request): View
    {
        $this->authorize('viewAny', Kos::class);
        $listKos = $request->user()->kos()->latest()->get();

        return view('owner.kos.manage', compact('listKos'));
    }

    /**
     * Halaman detail kos milik owner.
     */
    public function show(Kos $kos): View
    {
        $this->authorize('view', $kos);
        $kos->load(['facilities', 'photos']);

        return view('owner.kos.detail', compact('kos'));
    }

    /**
     * Form edit kos milik owner.
     */
    public function edit(Kos $kos): View
    {
        $this->authorize('update', $kos);
        $kos->load(['facilities', 'photos']);
        $facilities = Facility::orderBy('name')->get();

        return view('owner.kos.edit', compact('kos', 'facilities'));
    }

    /**
     * Update data kos milik owner.
     */
    public function update(UpdateKosRequest $request, Kos $kos): RedirectResponse
    {
        $this->authorize('update', $kos);

        $validated = $request->validated();

        // Mencegah perubahan owner_id melalui request payload
        unset($validated['owner_id']);

        // Pisahkan facilities, photos, dan delete_photos dari atribut tabel kos
        $facilityIds = $validated['facilities'] ?? [];
        $deletePhotoIds = $validated['delete_photos'] ?? [];
        unset($validated['facilities'], $validated['photos'], $validated['delete_photos']);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('kos', 'public');
            $validated['thumbnail'] = 'storage/' . $path;
        }

        $newUploadedFiles = [];
        $filesToDelete = [];

        DB::beginTransaction();
        try {
            $kos->update($validated);

            // Sinkronisasi relasi fasilitas
            $kos->facilities()->sync($facilityIds);

            // 1. Hapus foto yang dipilih (hanya foto milik kos ini - anti IDOR)
            if (!empty($deletePhotoIds)) {
                $photosToDelete = $kos->photos()->whereIn('id', $deletePhotoIds)->get();
                foreach ($photosToDelete as $photo) {
                    $filesToDelete[] = $photo->photo_path;
                    $photo->delete();
                }
            }

            // 2. Tambah foto baru jika ada
            if ($request->hasFile('photos')) {
                $currentMaxSort = (int) $kos->photos()->max('sort_order');
                $sortOrder = $currentMaxSort + 1;

                foreach ($request->file('photos') as $file) {
                    $photoPath = $file->store('kos/photos', 'public');
                    $newUploadedFiles[] = $photoPath;

                    $kos->photos()->create([
                        'photo_path' => $photoPath,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }

            DB::commit();

            // Hapus file fisik dari storage setelah DB commit berhasil
            foreach ($filesToDelete as $filePath) {
                Storage::disk('public')->delete($filePath);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            // Bersihkan file baru jika DB gagal commit
            foreach ($newUploadedFiles as $filePath) {
                Storage::disk('public')->delete($filePath);
            }
            throw $e;
        }

        $kos->refresh();

        return redirect()->route('owner.kos.show', $kos->slug)->with('success', 'Data kos berhasil diperbarui.');
    }

    /**
     * Hapus kos milik owner menggunakan Soft Delete.
     */
    public function destroy(Kos $kos): RedirectResponse
    {
        $this->authorize('delete', $kos);

        $kos->delete();

        return redirect()->route('owner.kos.my')->with('success', 'Kos berhasil dihapus.');
    }

    /**
     * Halaman penilaian kos untuk owner.
     */
    public function penilaian(Request $request): View
    {
        $owner = $request->user();
        $ownerKos = $owner->kos()->with(['reviews' => function ($q) {
            $q->latest();
        }])->get();

        $allReviews = Review::whereIn('kos_id', $ownerKos->pluck('id'))->latest()->get();

        $ratings = [];
        foreach ($ownerKos as $item) {
            $kosReviews = $item->reviews;
            $count = $kosReviews->count();
            if ($count > 0) {
                $latest = $kosReviews->first();
                $ratings[] = [
                    'kos' => $item->title,
                    'slug' => $item->slug,
                    'rating' => round((float) $kosReviews->avg('rating'), 1),
                    'total' => $count,
                    'latest' => $latest->comment,
                    'reviewer' => $latest->reviewer_name,
                    'date' => $latest->created_at->translatedFormat('d F Y'),
                ];
            }
        }

        $totalUlasan = $allReviews->count();
        $rataRating = $totalUlasan > 0 ? round((float) $allReviews->avg('rating'), 1) : 0.0;

        return view('owner.kos.penilaian', compact('ratings', 'totalUlasan', 'rataRating', 'allReviews'));
    }

    /**
     * Halaman laporan statistik owner.
     */
    public function statistik(): View
    {
        $owner = Auth::user();
        $ownerKos = $owner->kos()->with(['rooms', 'bookings'])->get();
        $ownerKosIds = $ownerKos->pluck('id');

        // 1. Total Pendapatan dari invoice yang benar-benar dibayar
        $totalPendapatan = (float) Invoice::whereIn('kos_id', $ownerKosIds)
            ->where('status', 'paid')
            ->sum('total_amount');

        // 2. Total Booking milik owner
        $totalBooking = Booking::whereIn('kos_id', $ownerKosIds)->count();

        // 3. Tingkat Okupansi Kamar
        $totalRooms = Room::whereIn('kos_id', $ownerKosIds)->count();
        $occupiedRooms = Room::whereIn('kos_id', $ownerKosIds)->where('status', 'occupied')->count();

        if ($totalRooms > 0) {
            $tingkatHunian = (int) round(($occupiedRooms / $totalRooms) * 100);
        } else {
            $capacity = (int) $ownerKos->sum('rooms');
            $activeTenants = Booking::whereIn('kos_id', $ownerKosIds)->whereIn('status', ['confirmed', 'active'])->count();
            $tingkatHunian = $capacity > 0 ? (int) min(100, round(($activeTenants / $capacity) * 100)) : 0;
        }

        // 4. Pertumbuhan Pendapatan (dibandingkan bulan sebelumnya)
        $currMonthRev = (float) Invoice::whereIn('kos_id', $ownerKosIds)
            ->where('status', 'paid')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('total_amount');

        $prevMonthRev = (float) Invoice::whereIn('kos_id', $ownerKosIds)
            ->where('status', 'paid')
            ->whereMonth('paid_at', now()->subMonth()->month)
            ->whereYear('paid_at', now()->subMonth()->year)
            ->sum('total_amount');

        $pertumbuhan = $prevMonthRev > 0
            ? round((($currMonthRev - $prevMonthRev) / $prevMonthRev) * 100, 1)
            : ($currMonthRev > 0 ? 100.0 : 0.0);

        $summary = [
            'pendapatan' => $totalPendapatan,
            'booking' => $totalBooking,
            'tingkat_hunian' => $tingkatHunian,
            'pertumbuhan' => $pertumbuhan,
        ];

        // 5. Tren Pendapatan 6 Bulan Terakhir
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $dt = now()->subMonths($i);
            $val = (float) Invoice::whereIn('kos_id', $ownerKosIds)
                ->where('status', 'paid')
                ->whereMonth('paid_at', $dt->month)
                ->whereYear('paid_at', $dt->year)
                ->sum('total_amount');

            $monthlyRevenue[] = [
                'month' => $dt->translatedFormat('M'),
                'value' => $val,
            ];
        }

        // 6. Performa Masing-Masing Properti Kos
        $kosPerformance = [];
        foreach ($ownerKos as $k) {
            $kTotalRooms = $k->rooms()->count();
            $kOccupied = $k->rooms()->where('status', 'occupied')->count();

            if ($kTotalRooms > 0) {
                $kOcc = (int) round(($kOccupied / $kTotalRooms) * 100);
            } else {
                $kCap = (int) ($k->rooms ?? 0);
                $kActive = $k->bookings()->whereIn('status', ['confirmed', 'active'])->count();
                $kOcc = $kCap > 0 ? (int) min(100, round(($kActive / $kCap) * 100)) : 0;
            }

            $kBookings = $k->bookings()->count();
            $kRev = (float) $k->invoices()->where('status', 'paid')->sum('total_amount');

            $kosPerformance[] = [
                'title' => $k->title,
                'occupancy' => $kOcc,
                'booking' => $kBookings,
                'revenue' => $kRev,
            ];
        }

        return view('owner.laporan.statistik', compact('summary', 'monthlyRevenue', 'kosPerformance'));
    }

    /**
     * Halaman notifikasi owner (Data nyata dari database notifications).
     */
    public function notifikasi(): View
    {
        $dbNotifs = Auth::user()->notifications()->latest()->take(30)->get();

        $notifications = $dbNotifs->map(function ($n) {
            return [
                'id' => $n->id,
                'title' => $n->data['title'] ?? 'Pemberitahuan',
                'message' => $n->data['message'] ?? '',
                'time' => $n->created_at->diffForHumans(),
                'is_read' => $n->read_at !== null,
                'icon' => ($n->data['icon'] ?? 'fa-bell') . ' text-primary',
                'action_url' => $n->data['action_url'] ?? null,
            ];
        })->toArray();

        // Tandai seluruh notifikasi unread sebagai sudah dibaca
        Auth::user()->unreadNotifications->markAsRead();

        return view('owner.notifikasi.index', compact('notifications'));
    }

    /**
     * Balas ulasan dari penghuni kos.
     */
    public function replyReview(Request $request, Review $review): RedirectResponse
    {
        $owner = Auth::user();

        // Verifikasi kepemilikan kos
        if ($review->kos->owner_id !== $owner->id) {
            abort(403, 'Anda tidak berhak membalas ulasan pada properti ini.');
        }

        $validated = $request->validate([
            'reply' => ['required', 'string', 'min:3', 'max:1000'],
        ], [
            'reply.required' => 'Balasan ulasan wajib diisi.',
            'reply.min' => 'Balasan ulasan minimal 3 karakter.',
            'reply.max' => 'Balasan ulasan maksimal 1000 karakter.',
        ]);

        $review->update([
            'reply' => strip_tags($validated['reply']),
        ]);

        // Notifikasi ke reviewer jika memiliki akun
        try {
            $review->user?->notify(new \App\Notifications\TempatinNotification(
                'Balasan Pemilik Kos',
                'Pemilik ' . $review->kos->title . ' telah membalas ulasan Anda.',
                route('kos.show', $review->kos->slug) . '#reviews',
                'review',
                'fa-reply'
            ));
        } catch (\Throwable $e) {
            // Abaikan jika background notification gagal
        }

        return redirect()->back()->with('success', 'Balasan ulasan berhasil disimpan.');
    }

    /**
     * Tampilkan daftar penghuni dan masa hunian aktif pada properti milik owner.
     */
    public function penghuni(Request $request): View
    {
        $ownerId = Auth::id();
        $status = $request->query('status', 'active');

        $query = Booking::with(['customer', 'kos', 'room', 'contract'])
            ->whereHas('kos', function ($q) use ($ownerId) {
                $q->where('owner_id', $ownerId);
            });

        if ($status === 'active') {
            $query->where('status', 'active');
        } elseif ($status === 'confirmed') {
            $query->where('status', 'confirmed');
        } elseif ($status === 'completed') {
            $query->where('status', 'completed');
        } else {
            $query->whereIn('status', ['confirmed', 'active', 'completed']);
        }

        $tenants = $query->latest('start_date')->paginate(12)->withQueryString();

        $activeCount = Booking::whereHas('kos', fn($q) => $q->where('owner_id', $ownerId))->where('status', 'active')->count();
        $confirmedCount = Booking::whereHas('kos', fn($q) => $q->where('owner_id', $ownerId))->where('status', 'confirmed')->count();
        $completedCount = Booking::whereHas('kos', fn($q) => $q->where('owner_id', $ownerId))->where('status', 'completed')->count();

        return view('owner.penghuni.index', compact('tenants', 'status', 'activeCount', 'confirmedCount', 'completedCount'));
    }
}
