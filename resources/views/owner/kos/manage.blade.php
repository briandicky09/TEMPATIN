@extends('layouts.owner')

@section('title', 'Manajemen Kos - TEMPATIN')

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
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
                        <i class="fa fa-tasks mr-1"></i> PENGATURAN HUNIAN
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Manajemen Properti Kos
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Perbarui detail, foto, fasilitas, dan kelola ketersediaan kos Anda.
                    </p>
                </div>
                <div>
                    <a href="{{ route('owner.kos.create') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13.5px; padding: 10px 20px; border-radius: var(--radius-buttons); border: none;">
                        <i class="fa fa-plus-circle mr-1"></i> Tambah Kos Baru
                    </a>
                </div>
            </div>

            <!-- TABLE -->
            <div class="rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                @if(isset($listKos) && count($listKos) > 0)
                    <div class="table-responsive mb-0">
                        <table class="table mb-0 align-middle">
                            <thead style="background-color: var(--surface-page-canvas); border-bottom: var(--border-hairline);">
                                <tr>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Nama Kos</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Lokasi</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Harga / bln</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Status</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none; text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listKos as $kos)
                                    @php
                                        $isActive = in_array(strtolower($kos['status']), ['aktif', 'active']);
                                        $statusClass = 'background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline);';
                                    @endphp
                                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                                        <td style="padding: 16px 20px;">
                                            <div style="font-weight: 700; color: var(--color-midnight-ink); font-size: 14px;">
                                                {{ $kos['title'] }}
                                            </div>
                                            <div style="font-size: 12px; color: var(--color-stone);">
                                                Tipe: {{ ucfirst($kos['type']) }}
                                            </div>
                                        </td>
                                        <td style="padding: 16px 20px; font-size: 13.5px; color: var(--color-charcoal);">
                                            {{ $kos['city'] }}
                                        </td>
                                        <td style="padding: 16px 20px; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums; font-size: 14px;">
                                            Rp {{ number_format($kos['price'], 0, ',', '.') }}
                                        </td>
                                        <td style="padding: 16px 20px;">
                                            <span class="px-2 py-1 rounded-pill" style="{{ $statusClass }}; font-size: 11px; font-weight: 600;">
                                                {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td style="padding: 16px 20px; text-align: right;">
                                            <div class="d-inline-flex gap-1">
                                                <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="btn btn-sm" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 12px; border-radius: var(--radius-buttons); padding: 6px 12px;">
                                                    Detail
                                                </a>
                                                <a href="{{ route('owner.kos.edit', $kos['slug']) }}" class="btn btn-sm" style="background-color: #ffffff; color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 12px; border-radius: var(--radius-buttons); padding: 6px 12px;">
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; border-radius: 50%; background-color: var(--surface-page-canvas); color: var(--color-stone); font-size: 24px;">
                            <i class="fa fa-tasks"></i>
                        </div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                            Tidak Ada Kos untuk Dikelola
                        </h3>
                        <p style="font-size: 13.5px; color: var(--color-stone); max-width: 440px; margin: 0 auto 20px;">
                            Tambahkan properti kos baru untuk mulai mengelola ketersediaan kamar.
                        </p>
                        <a href="{{ route('owner.kos.create') }}" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13px; padding: 10px 20px; border-radius: var(--radius-buttons); border: none;">
                            + Tambah Kos Sekarang
                        </a>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
