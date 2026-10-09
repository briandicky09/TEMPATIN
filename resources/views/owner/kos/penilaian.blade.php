@extends('layouts.owner')

@section('title', 'Penilaian & Ulasan Kos - TEMPATIN')

@section('owner-content')
<div class="container">
    <div class="row">

        <!-- OWNER SIDEBAR -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            @include('partials.owner-sidebar')
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-lg-9">

            <!-- HEADER -->
            <div class="mb-4">
                <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
                    <i class="fa fa-star mr-1"></i> REPUTASI & KEPUASAN
                </div>
                <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                    Penilaian & Ulasan Penghuni
                </h1>
                <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                    Pantau kesan dan umpan balik langsung dari mahasiswa serta penyewa kamar kos Anda.
                </p>
            </div>

            <!-- KPI METRICS -->
            <div class="row mb-4">
                <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 6px;">Rata-rata Penilaian</div>
                        <div class="d-flex align-items-center">
                            <span style="font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;" class="mr-2">
                                {{ number_format($rataRating, 1, ',', '.') }}
                            </span>
                            <span style="color: #ffb110; font-size: 1.1rem;"><i class="fa fa-star"></i></span>
                            <span style="font-size: 12px; color: var(--color-stone);" class="ml-2">/ 5.0</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 6px;">Total Ulasan Diterima</div>
                        <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                            {{ $totalUlasan }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 6px;">Kos Memiliki Ulasan</div>
                        <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-notion-blue); font-variant-numeric: tabular-nums;">
                            {{ count($ratings) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE OF REVIEWS -->
            <div class="rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="table-responsive mb-0">
                    <table class="table mb-0 align-middle">
                        <thead style="background-color: var(--surface-page-canvas); border-bottom: var(--border-hairline);">
                            <tr>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Nama Kos</th>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Skor</th>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Ulasan Terbaru</th>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ratings as $rating)
                                <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                                    <td style="padding: 16px 20px;">
                                        <div style="font-weight: 700; color: var(--color-midnight-ink); font-size: 14px;">
                                            {{ $rating['kos'] }}
                                        </div>
                                        <div style="font-size: 12px; color: var(--color-stone);">
                                            {{ $rating['total'] }} ulasan masuk
                                        </div>
                                    </td>
                                    <td style="padding: 16px 20px;">
                                        <div class="d-flex align-items-center">
                                            <span style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;" class="mr-2">
                                                {{ number_format($rating['rating'], 1, ',', '.') }}
                                            </span>
                                            <span style="color: #ffb110; font-size: 12px;"><i class="fa fa-star"></i></span>
                                        </div>
                                    </td>
                                    <td style="padding: 16px 20px; font-size: 13.5px; color: var(--color-charcoal); max-width: 380px;">
                                        <div style="font-style: italic; margin-bottom: 4px;">&ldquo;{{ $rating['latest'] }}&rdquo;</div>
                                        <div style="font-size: 11.5px; color: var(--color-stone);">
                                            {{ $rating['reviewer'] }} • {{ $rating['date'] }}
                                        </div>
                                    </td>
                                    <td style="padding: 16px 20px; text-align: right;">
                                        <a href="{{ route('owner.kos.show', $rating['slug']) }}" class="btn btn-sm" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 12px; border-radius: var(--radius-buttons); padding: 6px 14px;">
                                            Detail Kos
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
