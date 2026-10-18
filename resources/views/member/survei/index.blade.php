@extends('layouts.app')

@section('title', 'Jadwal Survei Kos Saya - TEMPATIN')

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
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Jadwal Survei</li>
                </ol>
            </nav>
        </div>

        <section class="container">
            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <div class="d-inline-flex align-items-center mb-1 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-ink-black); font-size: 11px; font-weight: 600; border: 1px solid rgba(0, 117, 222, 0.2);">
                        <i class="fa fa-walking mr-1"></i> KUNJUNGAN LOKASI
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Jadwal Survei Kos Saya
                    </h1>
                    <p class="mb-0" style="color: var(--color-stone); font-size: 14px;">
                        Pantau status pengajuan kunjungan survei kos Anda ke pemilik properti.
                    </p>
                </div>
                <div>
                    <a href="{{ route('member.kos.index') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 9px 18px; border: none;">
                        <i class="fa fa-search mr-2"></i> Cari Kos Lain
                    </a>
                </div>
            </div>

            @if($surveys->isEmpty())
                <div class="text-center py-5" style="background-color: var(--surface-card); border: var(--border-hairline); border-radius: 14px;">
                    <div class="mb-3">
                        <i class="fa fa-calendar-times" style="font-size: 48px; color: var(--color-stone);"></i>
                    </div>
                    <h5 class="font-weight-bold" style="color: var(--color-midnight-ink);">Belum Ada Pengajuan Survei</h5>
                    <p class="text-muted small mb-4">Anda belum mengajukan jadwal survei untuk kos manapun saat ini.</p>
                    <a href="{{ route('member.kos.index') }}" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px;">
                        Jelajahi Kos Sekarang
                    </a>
                </div>
            @else
                <div class="row">
                    @foreach($surveys as $survey)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100" style="border: var(--border-hairline); border-radius: 14px; overflow: hidden; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                                <div style="height: 160px; position: relative; background: #f3f4f6;">
                                    @php
                                        $photoUrl = $survey->kos->photos->first()?->url ?? asset($survey->kos->thumbnail ?? 'assets/img/img-detail-01.jpg');
                                    @endphp
                                    <img src="{{ $photoUrl }}" alt="{{ $survey->kos->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    <div style="position: absolute; top: 12px; right: 12px;">
                                        @if($survey->status === 'approved')
                                            <span class="badge px-2 py-1" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                <i class="fa fa-check-circle mr-1"></i> Disetujui
                                            </span>
                                        @elseif($survey->status === 'pending')
                                            <span class="badge px-2 py-1" style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                <i class="fa fa-clock mr-1"></i> Menunggu Konfirmasi
                                            </span>
                                        @elseif($survey->status === 'rejected')
                                            <span class="badge px-2 py-1" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                <i class="fa fa-times-circle mr-1"></i> Ditolak
                                            </span>
                                        @elseif($survey->status === 'cancelled')
                                            <span class="badge px-2 py-1" style="background: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                <i class="fa fa-ban mr-1"></i> Dibatalkan
                                            </span>
                                        @else
                                            <span class="badge px-2 py-1" style="background: #eef2ff; color: #3730a3; border: 1px solid #c7d2fe; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                <i class="fa fa-flag-checkered mr-1"></i> Selesai
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column" style="padding: 18px;">
                                    <h5 class="card-title font-weight-bold mb-1" style="color: var(--color-midnight-ink); font-size: 16px;">
                                        <a href="{{ route('member.kos.show', $survey->kos->slug) }}" class="text-decoration-none text-dark">
                                            {{ $survey->kos->title }}
                                        </a>
                                    </h5>
                                    <p class="text-muted small mb-3">
                                        <i class="fa fa-map-marker-alt mr-1" style="color: var(--color-notion-blue);"></i>{{ $survey->kos->city ?? $survey->kos->address }}
                                    </p>

                                    <div class="p-2 mb-3 rounded" style="background-color: var(--surface-page-canvas); font-size: 13px;">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted"><i class="fa fa-calendar-alt mr-1"></i> Tanggal:</span>
                                            <span class="font-weight-600 text-dark">{{ $survey->survey_date->format('d M Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted"><i class="fa fa-clock mr-1"></i> Jam:</span>
                                            <span class="font-weight-600 text-dark">{{ $survey->survey_time }} WIB</span>
                                        </div>
                                        @if($survey->notes)
                                            <div class="mt-2 pt-2 border-top text-muted" style="font-size: 12px;">
                                                <strong>Catatan:</strong> {{ $survey->notes }}
                                            </div>
                                        @endif
                                        @if($survey->rejection_reason)
                                            <div class="mt-2 pt-2 border-top text-danger" style="font-size: 12px;">
                                                <strong>Alasan Tolak:</strong> {{ $survey->rejection_reason }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <a href="{{ route('member.kos.show', $survey->kos->slug) }}" class="btn btn-sm btn-outline-dark font-weight-600" style="border-radius: 8px;">
                                            Lihat Kos
                                        </a>
                                        @if($survey->status === 'pending')
                                            <form action="{{ route('member.surveys.cancel', $survey->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan survei ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger font-weight-600" style="border-radius: 8px;">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $surveys->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
