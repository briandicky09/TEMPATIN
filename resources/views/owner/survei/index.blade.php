@extends('layouts.owner')

@section('title', 'Jadwal Survei Masuk - TEMPATIN')

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
                        <i class="fa fa-walking mr-1"></i> SURVEI LOKASI
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Pengajuan Jadwal Survei
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Kelola dan konfirmasi jadwal kunjungan survei kos dari calon penyewa.
                    </p>
                </div>
            </div>

            <!-- STATUS FILTER PILLS -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('owner.surveys.index') }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ empty($status) ? 'background-color: var(--color-midnight-ink); color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Semua
                </a>
                <a href="{{ route('owner.surveys.index', ['status' => 'pending']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'pending' ? 'background-color: #d97706; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Menunggu Konfirmasi
                </a>
                <a href="{{ route('owner.surveys.index', ['status' => 'approved']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'approved' ? 'background-color: var(--color-notion-blue); color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Disetujui
                </a>
                <a href="{{ route('owner.surveys.index', ['status' => 'rejected']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'rejected' ? 'background-color: #dc2626; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Ditolak
                </a>
                <a href="{{ route('owner.surveys.index', ['status' => 'completed']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'completed' ? 'background-color: #059669; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Selesai
                </a>
            </div>

            <!-- TABLE CARD -->
            <div class="card" style="border: var(--border-hairline); border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden; background: #ffffff;">
                @if($surveys->isEmpty())
                    <div class="text-center py-5">
                        <i class="fa fa-calendar-check mb-3" style="font-size: 40px; color: var(--color-stone);"></i>
                        <h6 class="font-weight-bold" style="color: var(--color-midnight-ink);">Tidak Ada Jadwal Survei</h6>
                        <p class="text-muted small mb-0">Belum ada pengajuan survei dengan filter status yang dipilih.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                            <thead style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); font-weight: 600; border-bottom: var(--border-hairline);">
                                <tr>
                                    <th class="py-3 px-3">Calon Penyewa</th>
                                    <th class="py-3 px-3">Kos</th>
                                    <th class="py-3 px-3">Jadwal Kunjungan</th>
                                    <th class="py-3 px-3">Status</th>
                                    <th class="py-3 px-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($surveys as $survey)
                                    <tr style="border-bottom: var(--border-hairline);">
                                        <td class="py-3 px-3">
                                            <div class="font-weight-bold" style="color: var(--color-midnight-ink);">
                                                {{ $survey->customer->name ?? 'Pengguna' }}
                                            </div>
                                            <div class="text-muted small">
                                                <i class="fa fa-envelope mr-1"></i>{{ $survey->customer->email ?? '-' }}
                                                @if($survey->customer->phone)
                                                    <span class="mx-1">&bull;</span>
                                                    <i class="fa fa-phone mr-1"></i>{{ $survey->customer->phone }}
                                                @endif
                                            </div>
                                            @if($survey->notes)
                                                <div class="small mt-1 text-muted" style="font-style: italic;">
                                                    "{{ $survey->notes }}"
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3">
                                            <a href="{{ route('kos.show', $survey->kos->slug) }}" class="font-weight-600 text-decoration-none text-dark" target="_blank">
                                                {{ $survey->kos->title }}
                                            </a>
                                            <div class="text-muted small">{{ $survey->kos->city }}</div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="font-weight-600 text-dark">
                                                <i class="fa fa-calendar-day mr-1 text-primary"></i>
                                                {{ $survey->survey_date->format('d M Y') }}
                                            </div>
                                            <div class="text-muted small">
                                                <i class="fa fa-clock mr-1 text-secondary"></i>
                                                {{ $survey->survey_time }} WIB
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            @if($survey->status === 'approved')
                                                <span class="badge px-2 py-1" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                    Disetujui
                                                </span>
                                            @elseif($survey->status === 'pending')
                                                <span class="badge px-2 py-1" style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                    Menunggu Konfirmasi
                                                </span>
                                            @elseif($survey->status === 'rejected')
                                                <span class="badge px-2 py-1" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; font-size: 11.5px; font-weight: 600; border-radius: 6px;" title="{{ $survey->rejection_reason }}">
                                                    Ditolak
                                                </span>
                                            @elseif($survey->status === 'cancelled')
                                                <span class="badge px-2 py-1" style="background: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                    Dibatalkan
                                                </span>
                                            @else
                                                <span class="badge px-2 py-1" style="background: #eef2ff; color: #3730a3; border: 1px solid #c7d2fe; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <div class="d-inline-flex gap-1">
                                                @if($survey->status === 'pending')
                                                    <!-- Setujui -->
                                                    <form action="{{ route('owner.surveys.updateStatus', $survey->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="btn btn-sm btn-success font-weight-600" style="border-radius: 6px; font-size: 12px;">
                                                            <i class="fa fa-check mr-1"></i>Setujui
                                                        </button>
                                                    </form>

                                                    <!-- Tolak modal trigger -->
                                                    <button type="button" class="btn btn-sm btn-outline-danger font-weight-600 ml-1" data-toggle="modal" data-target="#modalRejectSurvey{{ $survey->id }}" style="border-radius: 6px; font-size: 12px;">
                                                        <i class="fa fa-times mr-1"></i>Tolak
                                                    </button>

                                                    <!-- Modal Tolak -->
                                                    <div class="modal fade text-left" id="modalRejectSurvey{{ $survey->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content" style="border-radius: 12px; border: var(--border-hairline);">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title font-weight-bold">Tolak Pengajuan Survei</h6>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <form action="{{ route('owner.surveys.updateStatus', $survey->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="rejected">
                                                                    <div class="modal-body">
                                                                        <div class="form-group mb-0">
                                                                            <label class="font-weight-600 small">Alasan Penolakan:</label>
                                                                            <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Contoh: Kamar sudah penuh / jadwal pemilik tidak berada di lokasi"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-sm btn-danger font-weight-bold">Konfirmasi Tolak</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($survey->status === 'approved')
                                                    <!-- Selesai -->
                                                    <form action="{{ route('owner.surveys.updateStatus', $survey->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="btn btn-sm btn-primary font-weight-600" style="border-radius: 6px; font-size: 12px;">
                                                            <i class="fa fa-flag-checkered mr-1"></i>Tandai Selesai
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 d-flex justify-content-center">
                        {{ $surveys->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
