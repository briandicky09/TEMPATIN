<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Survey;
use App\Notifications\TempatinNotification;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Customer submits a new survey request.
     */
    public function store(Request $request, string $slug)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', 'Silakan login terlebih dahulu untuk mengajukan survei.');
        }

        $kos = Kos::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'survey_date' => ['required', 'date', 'after_or_equal:today'],
            'survey_time' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        // Prevent duplicate pending surveys from the same user on the same kos
        $existing = Survey::where('customer_id', auth()->id())
            ->where('kos_id', $kos->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return back()->with('warning', 'Anda sudah memiliki pengajuan survei yang menunggu konfirmasi pemilik untuk kos ini.');
        }

        $survey = Survey::create([
            'kos_id' => $kos->id,
            'customer_id' => auth()->id(),
            'survey_date' => $validated['survey_date'],
            'survey_time' => $validated['survey_time'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);

        // Send notification to owner
        if ($kos->owner) {
            $kos->owner->notify(new TempatinNotification(
                'Pengajuan Survei Baru',
                auth()->user()->name . ' mengajukan survei kos ' . $kos->title . ' pada ' . date('d M Y', strtotime($survey->survey_date)) . ' pk ' . $survey->survey_time . '.',
                route('owner.surveys.index'),
                'survey',
                'fa-calendar-alt'
            ));
        }

        return back()->with('success', 'Pengajuan survei berhasil dikirim! Pemilik kos akan segera mengonfirmasi jadwal Anda.');
    }

    /**
     * Customer view their surveys.
     */
    public function customerIndex()
    {
        $surveys = Survey::with(['kos.photos'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('member.survei.index', compact('surveys'));
    }

    /**
     * Customer cancels a pending survey.
     */
    public function customerCancel(Survey $survey)
    {
        if ($survey->customer_id !== auth()->id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        if ($survey->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan survei berstatus pending yang dapat dibatalkan.');
        }

        $survey->update(['status' => 'cancelled']);

        return back()->with('success', 'Pengajuan survei telah dibatalkan.');
    }

    /**
     * Owner views surveys on their properties.
     */
    public function ownerIndex(Request $request)
    {
        $ownerId = auth()->id();
        $status = $request->query('status');

        $query = Survey::with(['customer', 'kos'])
            ->whereHas('kos', function ($q) use ($ownerId) {
                $q->where('owner_id', $ownerId);
            });

        if ($status && in_array($status, ['pending', 'approved', 'rejected', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        $surveys = $query->latest()->paginate(15)->withQueryString();

        return view('owner.survei.index', compact('surveys', 'status'));
    }

    /**
     * Owner updates survey status (approve, reject, complete).
     */
    public function ownerUpdateStatus(Request $request, Survey $survey)
    {
        // Ownership check
        if ($survey->kos->owner_id !== auth()->id()) {
            abort(403, 'Akses tidak diizinkan. Kos ini bukan milik Anda.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected,completed'],
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        if ($survey->status === 'cancelled') {
            return back()->with('error', 'Survei ini telah dibatalkan oleh calon penyewa.');
        }

        $updateData = ['status' => $validated['status']];
        if ($validated['status'] === 'rejected') {
            $updateData['rejection_reason'] = $validated['rejection_reason'] ?? 'Jadwal survei tidak memungkinkan.';
        }

        $survey->update($updateData);

        // Notify customer
        if ($survey->customer) {
            $statusLabel = match ($validated['status']) {
                'approved' => 'disetujui oleh pemilik kos',
                'rejected' => 'ditolak oleh pemilik kos',
                'completed' => 'telah selesai dilaksanakan',
                default => 'diperbarui',
            };

            $survey->customer->notify(new TempatinNotification(
                'Status Survei Kos Diperbarui',
                'Pengajuan survei kos ' . $survey->kos->title . ' Anda telah ' . $statusLabel . '.',
                route('member.surveys.index'),
                'survey',
                $validated['status'] === 'approved' ? 'fa-check-circle' : 'fa-info-circle'
            ));
        }

        return back()->with('success', 'Status pengajuan survei berhasil diperbarui.');
    }
}
