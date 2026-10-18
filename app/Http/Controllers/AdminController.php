<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Kos;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard ringkasan eksekutif platform superadmin.
     */
    public function dashboard()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $totalOwners = User::where('role', 'owner')->count();
        $totalKos = Kos::count();
        $totalBookings = Booking::count();
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');

        $recentKos = Kos::with('owner')->latest()->take(5)->get();
        $recentBookings = Booking::with(['customer', 'kos'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalOwners',
            'totalKos',
            'totalBookings',
            'totalRevenue',
            'recentKos',
            'recentBookings'
        ));
    }

    /**
     * Daftar seluruh listing kos untuk keperluan moderasi.
     */
    public function kosIndex(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Kos::with('owner');

        if ($status && in_array($status, ['active', 'inactive'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $listKos = $query->latest()->paginate(15)->withQueryString();

        return view('admin.kos.index', compact('listKos', 'status', 'search'));
    }

    /**
     * Moderasi status listing kos oleh admin (aktifkan atau nonaktifkan).
     */
    public function kosUpdateStatus(Request $request, Kos $kos)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $kos->update(['status' => $validated['status']]);

        return back()->with('success', 'Status publikasi kos ' . $kos->title . ' berhasil diperbarui.');
    }

    /**
     * Daftar pengguna platform (customer dan owner).
     */
    public function usersIndex(Request $request)
    {
        $role = $request->query('role');
        $search = $request->query('search');

        $query = User::query();

        if ($role && in_array($role, ['customer', 'owner', 'admin'])) {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users', 'role', 'search'));
    }

    /**
     * Audit log transaksi pemesanan seluruh platform (read-only).
     */
    public function bookingsIndex(Request $request)
    {
        $status = $request->query('status');

        $query = Booking::with(['customer', 'kos.owner', 'invoice.payments']);

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->paginate(20)->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'status'));
    }

    /**
     * Daftar seluruh ulasan untuk keperluan moderasi spam / ujaran kebencian.
     */
    public function reviewsIndex(Request $request)
    {
        $reviews = Review::with(['user', 'kos'])
            ->latest()
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Hapus ulasan yang melanggar ketentuan oleh admin.
     */
    public function destroyReview(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus dari sistem platform.');
    }
}
