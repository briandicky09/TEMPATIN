@extends('layouts.admin')

@section('title', 'Manajemen Pengguna Platform - TEMPATIN')

@section('admin-content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                Pengguna Platform
            </h1>
            <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                Daftar akun penyewa (customer), mitra pemilik (owner), dan administrator sistem.
            </p>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="card mb-4" style="border: var(--border-hairline); border-radius: 12px; background: #ffffff;">
        <div class="card-body p-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="form-row align-items-center">
                <div class="col-sm-5 mb-2 mb-sm-0">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau email pengguna..." value="{{ $search }}" style="border-radius: 8px;">
                </div>
                <div class="col-sm-4 mb-2 mb-sm-0">
                    <select name="role" class="form-control form-control-sm" style="border-radius: 8px;">
                        <option value="">-- Semua Role --</option>
                        <option value="customer" {{ $role === 'customer' ? 'selected' : '' }}>Customer (Penyewa)</option>
                        <option value="owner" {{ $role === 'owner' ? 'selected' : '' }}>Owner (Mitra Pemilik)</option>
                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin Platform</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-sm btn-primary btn-block font-weight-bold" style="border-radius: 8px;">
                        <i class="fa fa-filter mr-1"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card" style="border: var(--border-hairline); border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden; background: #ffffff;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); font-weight: 600; border-bottom: var(--border-hairline);">
                    <tr>
                        <th class="py-3 px-3">Nama Pengguna</th>
                        <th class="py-3 px-3">Email</th>
                        <th class="py-3 px-3">Telepon</th>
                        <th class="py-3 px-3">Role</th>
                        <th class="py-3 px-3 text-right">Tanggal Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr style="border-bottom: var(--border-hairline);">
                            <td class="py-3 px-3 font-weight-600 text-dark">
                                {{ $u->name }}
                            </td>
                            <td class="py-3 px-3 text-muted">
                                {{ $u->email }}
                            </td>
                            <td class="py-3 px-3 text-muted">
                                {{ $u->phone ?? '-' }}
                            </td>
                            <td class="py-3 px-3">
                                @if($u->role === 'admin')
                                    <span class="badge px-2 py-1" style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; font-size: 11px; border-radius: 4px;">
                                        Superadmin
                                    </span>
                                @elseif($u->role === 'owner')
                                    <span class="badge px-2 py-1" style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-size: 11px; border-radius: 4px;">
                                        Mitra Pemilik
                                    </span>
                                @else
                                    <span class="badge px-2 py-1" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-size: 11px; border-radius: 4px;">
                                        Customer
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-right text-muted small">
                                {{ $u->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Tidak ada akun pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 d-flex justify-content-center">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
