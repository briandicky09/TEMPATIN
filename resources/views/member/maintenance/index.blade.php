@extends('layouts.app')

@section('title', 'Laporan Kerusakan - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 6px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Laporan Kerusakan</li>
                </ol>
            </nav>
        </div>

        <section class="container">
            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <div class="d-inline-flex align-items-center mb-1 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-ink-black); font-size: 11px; font-weight: 600; border: 1px solid rgba(0, 117, 222, 0.2);">
                        <i class="fa fa-tools mr-1"></i> PEMELIHARAAN KAMAR
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Laporan Kerusakan &amp; Tiket Perbaikan
                    </h1>
                    <p class="mb-0" style="color: var(--color-stone); font-size: 14px;">
                        Kirimkan laporan kendala atau kerusakan fasilitas kamar kos kepada pemilik untuk penanganan cepat.
                    </p>
                </div>
                <div>
                    <a href="{{ route('member.maintenance.create') }}" class="btn font-weight-bold" style="background-color: var(--color-notion-blue); color: #ffffff; font-size: 13.5px; border-radius: var(--radius-buttons); padding: 9px 18px; border: none;">
                        <i class="fa fa-plus-circle mr-2"></i> Buat Laporan Baru
                    </a>
                </div>
            </div>

            @if($reports->isEmpty())
                <div class="text-center py-5" style="background-color: var(--surface-card); border: var(--border-hairline); border-radius: 14px;">
                    <div class="mb-3">
                        <i class="fa fa-wrench" style="font-size: 48px; color: var(--color-stone);"></i>
                    </div>
                    <h5 class="font-weight-bold" style="color: var(--color-midnight-ink);">Belum Ada Laporan Kerusakan</h5>
                    <p class="text-muted small mb-4">Semua fasilitas hunian Anda berjalan dengan baik tanpa keluhan tercatat.</p>
                    <a href="{{ route('member.maintenance.create') }}" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px;">
                        Laporkan Kerusakan Baru
                    </a>
                </div>
            @else
                <div class="row">
                    @foreach($reports as $report)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100" style="border: var(--border-hairline); border-radius: 14px; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="font-weight-bold mb-1" style="color: var(--color-midnight-ink); font-size: 16px;">
                                                {{ $report->title }}
                                            </h5>
                                            <div class="text-muted small">
                                                <i class="fa fa-building mr-1"></i>{{ $report->kos->title }}
                                                @if($report->room)
                                                    &bull; Kamar #{{ $report->room->room_number }} (Lt {{ $report->room->floor }})
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            @if($report->status === 'open')
                                                <span class="badge px-2 py-1" style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                                    Menunggu Penanganan
                                                </span>
                                            @elseif($report->status === 'in_progress')
                                                <span class="badge px-2 py-1" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                                    Sedang Dikerjakan
                                                </span>
                                            @elseif($report->status === 'resolved')
                                                <span class="badge px-2 py-1" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                                    Selesai Diperbaiki
                                                </span>
                                            @else
                                                <span class="badge px-2 py-1" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="text-muted small mb-3" style="line-height: 1.6;">
                                        {{ $report->description }}
                                    </p>

                                    @if($report->photo)
                                        <div class="mb-3">
                                            <a href="{{ asset('storage/' . $report->photo) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto Kerusakan" class="img-thumbnail" style="max-height: 120px; border-radius: 8px;">
                                            </a>
                                        </div>
                                    @endif

                                    @if($report->owner_notes)
                                        <div class="p-2 mb-3 rounded" style="background-color: var(--surface-page-canvas); border: var(--border-hairline); font-size: 12.5px;">
                                            <strong class="text-dark"><i class="fa fa-comment-dots mr-1 text-primary"></i> Catatan Pemilik:</strong>
                                            <div class="text-muted mt-1">{{ $report->owner_notes }}</div>
                                        </div>
                                    @endif

                                    <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center text-muted" style="font-size: 12px;">
                                        <span>Dilaporkan pada {{ $report->created_at->format('d M Y, H:i') }} WIB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $reports->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
