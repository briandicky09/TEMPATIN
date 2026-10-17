<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKosRequest;
use App\Http\Requests\UpdateKosRequest;
use App\Models\Facility;
use App\Models\Kos;
use App\Models\Review;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $summary = [
            'pendapatan' => 31250000,
            'booking' => 42,
            'tingkat_hunian' => 78,
            'pertumbuhan' => 12.5,
        ];

        $monthlyRevenue = [
            ['month' => 'Mar', 'value' => 4200000],
            ['month' => 'Apr', 'value' => 5100000],
            ['month' => 'Mei', 'value' => 4600000],
            ['month' => 'Jun', 'value' => 5800000],
            ['month' => 'Jul', 'value' => 5300000],
            ['month' => 'Agu', 'value' => 7000000],
        ];

        $kosPerformance = [
            ['title' => 'Kos Putri Melati', 'occupancy' => 92, 'booking' => 18, 'revenue' => 15300000],
            ['title' => 'Kos Putra Anggrek', 'occupancy' => 81, 'booking' => 15, 'revenue' => 11250000],
            ['title' => 'Kos Eksklusif Mawar', 'occupancy' => 60, 'booking' => 9, 'revenue' => 13500000],
        ];

        return view('owner.laporan.statistik', compact('summary', 'monthlyRevenue', 'kosPerformance'));
    }

    /**
     * Halaman notifikasi owner.
     */
    public function notifikasi(): View
    {
        $notifications = [
            [
                'title' => 'Pesanan Baru',
                'message' => 'Ada pesanan baru untuk Kos Putri Melati dari Dewi Sartika.',
                'time' => '10 menit yang lalu',
                'is_read' => false,
                'icon' => 'fa-bell text-primary',
            ],
            [
                'title' => 'Pembayaran Berhasil',
                'message' => 'Pembayaran untuk INV-2026-08-0001 telah berhasil dikonfirmasi.',
                'time' => '1 jam yang lalu',
                'is_read' => true,
                'icon' => 'fa-check-circle text-success',
            ],
            [
                'title' => 'Pertanyaan Baru',
                'message' => 'Ada pesan pertanyaan baru terkait Kos Putra Anggrek.',
                'time' => '1 hari yang lalu',
                'is_read' => true,
                'icon' => 'fa-envelope text-info',
            ],
        ];

        return view('owner.notifikasi.index', compact('notifications'));
    }
}
