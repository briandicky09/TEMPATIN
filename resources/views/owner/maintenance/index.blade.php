@extends('layouts.owner')

@section('title', 'Laporan Kerusakan Properti - TEMPATIN')

@section('owner-content')
<div class="container">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            @include('partials.owner-sidebar')
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-lg-9">

            <!-- HEADER -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-ink-black); font-size: 11px; font-weight: 600;">
                        <i class="fa fa-tools mr-1"></i> PEMELIHARAAN UNIT
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Laporan Kerusakan &amp; Perbaikan
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Tinjau keluhan penghuni, tindak lanjuti perbaikan fasilitas kamar, dan perbarui status pengerjaan.
                    </p>
                </div>
            </div>

            <!-- STATUS FILTER PILLS -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('owner.maintenance.index') }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ empty($status) ? 'background-color: var(--color-midnight-ink); color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Semua
                </a>
                <a href="{{ route('owner.maintenance.index', ['status' => 'open']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'open' ? 'background-color: #d97706; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Menunggu Penanganan
                </a>
                <a href="{{ route('owner.maintenance.index', ['status' => 'in_progress']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'in_progress' ? 'background-color: var(--color-notion-blue); color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Sedang Dikerjakan
                </a>
                <a href="{{ route('owner.maintenance.index', ['status' => 'resolved']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'resolved' ? 'background-color: #059669; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Selesai
                </a>
                <a href="{{ route('owner.maintenance.index', ['status' => 'rejected']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'rejected' ? 'background-color: #dc2626; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Ditolak
                </a>
            </div>

            <!-- TABLE CARD -->
            <div class="card" style="border: var(--border-hairline); border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden; background: #ffffff;">
                @if($reports->isEmpty())
                    <div class="text-center py-5">
                        <i class="fa fa-clipboard-check mb-3" style="font-size: 40px; color: var(--color-stone);"></i>
                        <h6 class="font-weight-bold" style="color: var(--color-midnight-ink);">Tidak Ada Tiket Perbaikan</h6>
                        <p class="text-muted small mb-0">Belum ada laporan kerusakan pada filter yang dipilih.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                            <thead style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); font-weight: 600; border-bottom: var(--border-hairline);">
                                <tr>
                                    <th class="py-3 px-3">Laporan &amp; Keluhan</th>
                                    <th class="py-3 px-3">Penghuni</th>
                                    <th class="py-3 px-3">Properti &amp; Kamar</th>
                                    <th class="py-3 px-3">Status</th>
                                    <th class="py-3 px-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr style="border-bottom: var(--border-hairline);">
                                        <td class="py-3 px-3">
                                            <div class="font-weight-bold" style="color: var(--color-midnight-ink);">
                                                {{ $report->title }}
                                            </div>
                                            <div class="text-muted small text-truncate" style="max-width: 260px;">
                                                {{ $report->description }}
                                            </div>
                                            @if($report->photo)
                                                <div class="mt-1">
                                                    <a href="{{ asset('storage/' . $report->photo) }}" target="_blank" class="small text-primary font-weight-600">
                                                        <i class="fa fa-image mr-1"></i>Lihat Foto Bukti
                                                    </a>
                                                </div>
                                            @endif
                                            @if($report->owner_notes)
                                                <div class="small mt-1 text-muted" style="font-style: italic;">
                                                    "Catatan: {{ $report->owner_notes }}"
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="font-weight-600 text-dark">{{ $report->customer->name ?? 'Penghuni' }}</div>
                                            <div class="text-muted small">
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $report->customer->phone ?? '') }}" target="_blank" style="color: #059669; text-decoration: none;">
                                                    <i class="fab fa-whatsapp mr-1"></i>{{ $report->customer->phone ?? '-' }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="font-weight-600 text-dark">{{ $report->kos->title }}</div>
                                            <div class="text-muted small">
                                                @if($report->room)
                                                    Kamar #{{ $report->room->room_number }} (Lt {{ $report->room->floor }})
                                                @else
                                                    Kamar Standar
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            @if($report->status === 'open')
                                                <span class="badge px-2 py-1" style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                                    Menunggu
                                                </span>
                                            @elseif($report->status === 'in_progress')
                                                <span class="badge px-2 py-1" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                                    Sedang Dikerjakan
                                                </span>
                                            @elseif($report->status === 'resolved')
                                                <span class="badge px-2 py-1" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                                    Selesai
                                                </span>
                                            @else
                                                <span class="badge px-2 py-1" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <button type="button" class="btn btn-sm btn-outline-primary font-weight-600" data-toggle="modal" data-target="#modalUpdateReport{{ $report->id }}" style="border-radius: 6px; font-size: 12px;">
                                                <i class="fa fa-edit mr-1"></i>Tindak Lanjut
                                            </button>

                                            <!-- Modal Update Status -->
                                            <div class="modal fade text-left" id="modalUpdateReport{{ $report->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content" style="border-radius: 12px; border: var(--border-hairline);">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title font-weight-bold">Tindak Lanjut Laporan Kerusakan</h6>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form action="{{ route('owner.maintenance.updateStatus', $report->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-body">
                                                                <div class="form-group mb-3">
                                                                    <label class="font-weight-600 small">Pilih Status Penanganan:</label>
                                                                    <select name="status" class="form-control" style="border-radius: 8px;">
                                                                        <option value="open" {{ $report->status === 'open' ? 'selected' : '' }}>Menunggu Penanganan</option>
                                                                        <option value="in_progress" {{ $report->status === 'in_progress' ? 'selected' : '' }}>Sedang Dalam Proses Perbaikan</option>
                                                                        <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Telah Berhasil Diperbaiki (Selesai)</option>
                                                                        <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Tolak Keluhan</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-0">
                                                                    <label class="font-weight-600 small">Catatan Penanganan (Opsional):</label>
                                                                    <textarea name="owner_notes" class="form-control" rows="3" placeholder="Contoh: Tukang ledeng dijadwalkan datang besok pukul 10.00" style="border-radius: 8px;">{{ $report->owner_notes }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-sm btn-primary font-weight-bold">Simpan Status</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 d-flex justify-content-center">
                        {{ $reports->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
