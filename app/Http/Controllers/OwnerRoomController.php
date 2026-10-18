<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OwnerRoomController extends Controller
{
    /**
     * Tampilkan daftar kamar untuk kos tertentu milik owner.
     */
    public function index(Kos $kos)
    {
        $this->authorizeOwner($kos);

        $rooms = $kos->rooms()->orderBy('room_number')->get();

        return view('owner.rooms.index', compact('kos', 'rooms'));
    }

    /**
     * Simpan kamar baru.
     */
    public function store(Request $request, Kos $kos)
    {
        $this->authorizeOwner($kos);

        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms')->where(function ($query) use ($kos) {
                    return $query->where('kos_id', $kos->id);
                }),
            ],
            'floor' => 'nullable|string|max:50',
            'room_type' => 'nullable|string|max:100',
            'price_override' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string|max:500',
        ], [
            'room_number.required' => 'Nomor kamar wajib diisi.',
            'room_number.unique' => 'Nomor kamar sudah terdaftar pada kos ini.',
            'status.in' => 'Status kamar tidak valid.',
        ]);

        $validated['kos_id'] = $kos->id;

        Room::create($validated);

        return redirect()->route('owner.kos.rooms.index', $kos->slug)
            ->with('success', 'Kamar nomor ' . $validated['room_number'] . ' berhasil ditambahkan.');
    }

    /**
     * Perbarui data kamar.
     */
    public function update(Request $request, Kos $kos, Room $room)
    {
        $this->authorizeOwner($kos);

        if ($room->kos_id !== $kos->id) {
            abort(404, 'Kamar tidak ditemukan pada kos ini.');
        }

        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms')->where(function ($query) use ($kos) {
                    return $query->where('kos_id', $kos->id);
                })->ignore($room->id),
            ],
            'floor' => 'nullable|string|max:50',
            'room_type' => 'nullable|string|max:100',
            'price_override' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string|max:500',
        ], [
            'room_number.required' => 'Nomor kamar wajib diisi.',
            'room_number.unique' => 'Nomor kamar sudah terdaftar pada kos ini.',
            'status.in' => 'Status kamar tidak valid.',
        ]);

        $room->update($validated);

        return redirect()->route('owner.kos.rooms.index', $kos->slug)
            ->with('success', 'Data kamar ' . $room->room_number . ' berhasil diperbarui.');
    }

    /**
     * Hapus kamar.
     */
    public function destroy(Kos $kos, Room $room)
    {
        $this->authorizeOwner($kos);

        if ($room->kos_id !== $kos->id) {
            abort(404, 'Kamar tidak ditemukan pada kos ini.');
        }

        // Cegah hapus kamar jika ada booking aktif
        $hasActiveBooking = $room->bookings()
            ->whereIn('status', ['confirmed', 'active', 'approved'])
            ->exists();

        if ($hasActiveBooking) {
            return redirect()->route('owner.kos.rooms.index', $kos->slug)
                ->with('error', 'Kamar tidak dapat dihapus karena sedang terkait dengan booking aktif.');
        }

        $roomNumber = $room->room_number;
        $room->delete();

        return redirect()->route('owner.kos.rooms.index', $kos->slug)
            ->with('success', 'Kamar ' . $roomNumber . ' berhasil dihapus.');
    }

    /**
     * Pastikan kos adalah milik owner yang login.
     */
    private function authorizeOwner(Kos $kos): void
    {
        if ($kos->owner_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses ke properti ini.');
        }
    }
}
