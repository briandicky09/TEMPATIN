@extends('layouts.admin')

@section('title', 'Moderasi Ulasan - TEMPATIN')

@section('admin-content')
<div>
    <div class="mb-4">
        <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
            Moderasi Ulasan Platform
        </h1>
        <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
            Kelola penilaian dan ulasan pengguna untuk memastikan komunitas platform yang aman dan tepercaya.
        </p>
    </div>

    <!-- TABLE -->
    <div class="card" style="border: var(--border-hairline); border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden; background: #ffffff;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); font-weight: 600; border-bottom: var(--border-hairline);">
                    <tr>
                        <th class="py-3 px-3">Penulis Ulasan</th>
                        <th class="py-3 px-3">Kos</th>
                        <th class="py-3 px-3">Rating</th>
                        <th class="py-3 px-3">Komentar</th>
                        <th class="py-3 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $rev)
                        <tr style="border-bottom: var(--border-hairline);">
                            <td class="py-3 px-3">
                                <div class="font-weight-600 text-dark">{{ $rev->user->name ?? $rev->author_name }}</div>
                                @if($rev->is_verified_tenant)
                                    <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 10px;">Verified Tenant</span>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                <a href="{{ route('kos.show', $rev->kos->slug) }}" target="_blank" class="font-weight-600 text-dark text-decoration-none">
                                    {{ $rev->kos->title }}
                                </a>
                            </td>
                            <td class="py-3 px-3">
                                <span class="font-weight-bold text-warning">
                                    <i class="fa fa-star"></i> {{ number_format($rev->rating, 1) }}
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                <div class="text-muted small" style="max-width: 320px;">
                                    "{{ $rev->comment }}"
                                </div>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger font-weight-600" style="border-radius: 6px; font-size: 12px;">
                                        <i class="fa fa-trash-alt mr-1"></i>Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada ulasan pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 d-flex justify-content-center">
            {{ $reviews->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
