@extends('layouts.customer')

@section('title', 'Kos Saya - TEMPATIN')

@section('customer-content')

<div class="mb-4">
    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
        <i class="fa fa-bed mr-1"></i> HUNIAN AKTIF
    </div>
    <h1 style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
        Kos yang Sedang Disewa
    </h1>
    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
        Daftar hunian aktif yang sedang kamu tempati melalui pemesanan resmi TEMPATIN.
    </p>
</div>

<div class="row">
    @forelse($rentedKos as $kos)
    <div class="col-md-6 mb-4">
        <div class="notion-kos-card h-100 d-flex flex-column justify-content-between p-3" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
            <div>
                <div class="position-relative overflow-hidden mb-3 rounded" style="height: 190px;">
                    <img src="{{ asset($kos['thumbnail']) }}" class="w-100 h-100" alt="{{ $kos['title'] }}" style="object-fit: cover;">
                    <div class="position-absolute" style="top: 10px; left: 10px;">
                        <span class="badge" style="background: rgba(255, 255, 255, 0.95); color: var(--color-midnight-ink); font-weight: 600; font-size: 11px; border: var(--border-hairline); padding: 4px 8px; border-radius: 4px;">
                            Kos {{ $kos['type'] }}
                        </span>
                    </div>
                </div>

                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                    {{ $kos['title'] }}
                </h3>
                <div class="d-flex align-items-center mb-2" style="font-size: 13px; color: var(--color-stone);">
                    <i class="fa fa-map-marker-alt mr-2 text-danger"></i> {{ $kos['city'] }}
                </div>
                <div class="d-flex align-items-center mb-3" style="font-size: 13px; color: var(--color-stone);">
                    <i class="fa fa-calendar-alt mr-2 text-primary"></i> Periode: {{ $kos['periode'] }}
                </div>
            </div>

            <div class="pt-3 border-top d-flex align-items-center justify-content-between" style="border-color: rgba(0,0,0,0.06) !important;">
                <div>
                    <span style="font-size: 11px; color: var(--color-stone); display: block;">Biaya Sewa</span>
                    <span style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                        Rp {{ number_format($kos['price'], 0, ',', '.') }}
                    </span>
                    <span style="font-size: 11px; color: var(--color-stone);">/ bln</span>
                </div>
                <a href="{{ route('kos.show', $kos['slug']) }}" class="btn btn-sm btn-ghost" style="font-weight: 600; font-size: 12px; border-radius: var(--radius-buttons); padding: 8px 14px;">
                    Detail Kamar
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="p-5 text-center rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; border-radius: 50%; background-color: var(--surface-page-canvas); color: var(--color-stone); font-size: 24px;">
                <i class="fa fa-bed"></i>
            </div>
            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                Belum Ada Kos yang Disewa
            </h3>
            <p style="font-size: 13.5px; color: var(--color-stone); max-width: 440px; margin: 0 auto 20px;">
                Kamu belum memiliki kamar kos aktif saat ini. Cari ribuan pilihan kos dengan harga terjangkau di sekitar kampusmu sekarang.
            </p>
            <a href="{{ route('search.kos') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13px; padding: 10px 20px; border-radius: var(--radius-buttons); border: none;">
                <i class="fa fa-search mr-2"></i> Cari Kos Sekarang
            </a>
        </div>
    </div>
    @endforelse
</div>

@endsection
