@extends('layouts.admin')

@section('title', 'Moderasi Listing Kos - TEMPATIN')

@section('admin-content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                Moderasi Listing Kos
            </h1>
            <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                Kelola status penayangan properti kos pada platform publik TEMPATIN.
            </p>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="card mb-4" style="border: var(--border-hairline); border-radius: 12px; background: #ffffff;">
        <div class="card-body p-3">
            <form action="{{ route('admin.kos.index') }}" method="GET" class="form-row align-items-center">
                <div class="col-sm-5 mb-2 mb-sm-0">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama kos atau kota..." value="{{ $search }}" style="border-radius: 8px;">
                </div>
                <div class="col-sm-4 mb-2 mb-sm-0">
                    <select name="status" class="form-control form-control-sm" style="border-radius: 8px;">
                        <option value="">-- Semua Status --</option>
                        <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif (Tayang)</option>
                        <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Nonaktif / Ditangguhkan</option>
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
                        <th class="py-3 px-3">Properti Kos</th>
                        <th class="py-3 px-3">Pemilik</th>
                        <th class="py-3 px-3">Tarif / Bulan</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3 text-right">Moderasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listKos as $k)
                        <tr style="border-bottom: var(--border-hairline);">
                            <td class="py-3 px-3">
                                <a href="{{ route('kos.show', $k->slug) }}" target="_blank" class="font-weight-bold text-dark text-decoration-none">
                                    {{ $k->title }}
                                </a>
                                <div class="text-muted small">
                                    <i class="fa fa-map-marker-alt mr-1"></i>{{ $k->city ?? $k->address }} &bull; Tipe: Kos {{ $k->type }}
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <div class="font-weight-600 text-dark">{{ $k->owner->name ?? 'Pemilik' }}</div>
                                <div class="text-muted small">{{ $k->owner->email ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-3 font-weight-600 text-dark">
                                Rp {{ number_format($k->price, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3">
                                @if($k->status === 'active')
                                    <span class="badge px-2 py-1" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11.5px; border-radius: 6px;">
                                        Tayang Aktif
                                    </span>
                                @else
                                    <span class="badge px-2 py-1" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; font-size: 11.5px; border-radius: 6px;">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-right">
                                <form action="{{ route('admin.kos.updateStatus', $k->slug) }}" method="POST" class="d-inline-flex gap-1">
                                    @csrf
                                    @method('PATCH')
                                    @if($k->status === 'active')
                                        <input type="hidden" name="status" value="inactive">
                                        <button type="submit" class="btn btn-sm btn-outline-danger font-weight-600" style="border-radius: 6px; font-size: 12px;" onclick="return confirm('Nonaktifkan penayangan kos ini?')">
                                            <i class="fa fa-ban mr-1"></i>Nonaktifkan
                                        </button>
                                    @else
                                        <input type="hidden" name="status" value="active">
                                        <button type="submit" class="btn btn-sm btn-outline-success font-weight-600" style="border-radius: 6px; font-size: 12px;">
                                            <i class="fa fa-check mr-1"></i>Aktifkan
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Tidak ada properti kos yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 d-flex justify-content-center">
            {{ $listKos->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
