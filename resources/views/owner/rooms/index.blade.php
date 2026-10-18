@extends('layouts.owner')

@section('title', 'Inventaris Kamar: ' . $kos->title . ' - TEMPATIN')

@section('owner-content')
<div class="container">
    <div class="row">

        <!-- OWNER SIDEBAR -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            @include('partials.owner-sidebar')
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-lg-9">

            <!-- BREADCRUMB -->
            <div class="mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                        <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}" style="color: var(--color-stone); text-decoration: none;">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('owner.kos.show', $kos->slug) }}" style="color: var(--color-stone); text-decoration: none;">{{ $kos->title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Inventaris Kamar</li>
                    </ol>
                </nav>
            </div>

            <!-- FLASH ALERTS -->
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center mb-4" role="alert" style="border-radius: var(--radius-buttons); font-size: 13.5px; border-left: 4px solid #10b981;">
                    <i class="fa fa-check-circle mr-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center mb-4" role="alert" style="border-radius: var(--radius-buttons); font-size: 13.5px; border-left: 4px solid #ef4444;">
                    <i class="fa fa-exclamation-circle mr-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-4" role="alert" style="border-radius: var(--radius-buttons); font-size: 13.5px;">
                    <ul class="mb-0 pl-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- HEADER -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-ink-black); font-size: 11px; font-weight: 600;">
                        <i class="fa fa-door-open mr-1"></i> INVENTARIS KAMAR INDIVIDUAL
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Kamar Kos: {{ $kos->title }}
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Kelola nomor kamar, tipe, lantai, dan ketersediaan individual secara akurat.
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modalAddRoom" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13.5px; padding: 10px 18px; border-radius: var(--radius-buttons); border: none;">
                        <i class="fa fa-plus-circle mr-1"></i> Tambah Kamar
                    </button>
                    <a href="{{ route('owner.kos.show', $kos->slug) }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-weight: 600; font-size: 13.5px; padding: 10px 18px; border-radius: var(--radius-buttons);">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali ke Detail
                    </a>
                </div>
            </div>

            <!-- STATS PILLS -->
            <div class="row mb-4 g-3">
                @php
                    $totalRooms = $rooms->count();
                    $availableRooms = $rooms->where('status', 'available')->count();
                    $occupiedRooms = $rooms->where('status', 'occupied')->count();
                    $maintenanceRooms = $rooms->where('status', 'maintenance')->count();
                @endphp
                <div class="col-sm-3 col-6">
                    <div class="p-3 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 600;">Total Kamar</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--color-midnight-ink);">{{ $totalRooms }}</div>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="p-3 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 600;">Tersedia</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #10b981;">{{ $availableRooms }}</div>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="p-3 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 600;">Terisi</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--color-notion-blue);">{{ $occupiedRooms }}</div>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="p-3 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 600;">Maintenance</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #f59e0b;">{{ $maintenanceRooms }}</div>
                    </div>
                </div>
            </div>

            <!-- ROOMS TABLE -->
            <div class="rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                @if($rooms->isNotEmpty())
                    <div class="table-responsive mb-0">
                        <table class="table mb-0 align-middle">
                            <thead style="background-color: var(--surface-page-canvas); border-bottom: var(--border-hairline);">
                                <tr>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Nomor Kamar</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Lantai</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Tipe</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Tarif</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Status</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none; text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                                        <td style="padding: 16px 20px;">
                                            <div style="font-weight: 700; color: var(--color-midnight-ink); font-size: 14px;">
                                                Kamar {{ $room->room_number }}
                                            </div>
                                            @if($room->description)
                                                <div style="font-size: 12px; color: var(--color-stone);">{{ $room->description }}</div>
                                            @endif
                                        </td>
                                        <td style="padding: 16px 20px; font-size: 13.5px; color: var(--color-charcoal);">
                                            {{ $room->floor ?? 'Lantai 1' }}
                                        </td>
                                        <td style="padding: 16px 20px; font-size: 13.5px; color: var(--color-charcoal);">
                                            {{ $room->room_type ?? 'Standar' }}
                                        </td>
                                        <td style="padding: 16px 20px; font-size: 13.5px; color: var(--color-midnight-ink); font-weight: 600;">
                                            @if($room->price_override)
                                                Rp {{ number_format($room->price_override, 0, ',', '.') }}
                                                <span class="badge bg-light text-muted" style="font-size: 10px;">Khusus</span>
                                            @else
                                                Rp {{ number_format($kos->price, 0, ',', '.') }}
                                                <span class="badge bg-light text-muted" style="font-size: 10px;">Standar</span>
                                            @endif
                                        </td>
                                        <td style="padding: 16px 20px;">
                                            @if($room->status === 'available')
                                                <span class="badge px-2 py-1 rounded" style="background-color: #ecfdf5; color: #065f46; font-size: 11px; font-weight: 600;">
                                                    <i class="fa fa-circle mr-1" style="font-size: 7px;"></i> Tersedia
                                                </span>
                                            @elseif($room->status === 'occupied')
                                                <span class="badge px-2 py-1 rounded" style="background-color: #eff6ff; color: #1e40af; font-size: 11px; font-weight: 600;">
                                                    <i class="fa fa-user-check mr-1" style="font-size: 9px;"></i> Terisi
                                                </span>
                                            @else
                                                <span class="badge px-2 py-1 rounded" style="background-color: #fef3c7; color: #92400e; font-size: 11px; font-weight: 600;">
                                                    <i class="fa fa-tools mr-1" style="font-size: 9px;"></i> Maintenance
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 16px 20px; text-align: right;">
                                            <div class="d-inline-flex gap-1">
                                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditRoom{{ $room->id }}" style="background-color: #ffffff; color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 12px; border-radius: var(--radius-buttons); padding: 5px 10px;">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
                                                <form action="{{ route('owner.kos.rooms.destroy', [$kos->slug, $room->id]) }}" method="POST" onsubmit="return confirm('Hapus kamar nomor {{ $room->room_number }}?');" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm" style="background-color: #ffffff; color: #ef4444; border: var(--border-hairline); font-weight: 600; font-size: 12px; border-radius: var(--radius-buttons); padding: 5px 10px;">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- MODAL EDIT ROOM -->
                                            <div class="modal fade text-left" id="modalEditRoom{{ $room->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content" style="border-radius: var(--radius-cards); border: var(--border-hairline);">
                                                        <form action="{{ route('owner.kos.rooms.update', [$kos->slug, $room->id]) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header" style="border-bottom: var(--border-hairline);">
                                                                <h5 class="modal-title" style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink);">
                                                                    Edit Kamar {{ $room->room_number }}
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body" style="text-align: left;">
                                                                <div class="mb-3">
                                                                    <label class="form-label" style="font-size: 13px; font-weight: 600;">Nomor / Kode Kamar <span class="text-danger">*</span></label>
                                                                    <input type="text" name="room_number" class="form-control" value="{{ old('room_number', $room->room_number) }}" required style="border-radius: var(--radius-buttons);">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6 mb-3">
                                                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Lantai</label>
                                                                        <input type="text" name="floor" class="form-control" value="{{ old('floor', $room->floor) }}" placeholder="Contoh: Lantai 1" style="border-radius: var(--radius-buttons);">
                                                                    </div>
                                                                    <div class="col-6 mb-3">
                                                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Tipe Kamar</label>
                                                                        <input type="text" name="room_type" class="form-control" value="{{ old('room_type', $room->room_type) }}" placeholder="Contoh: Deluxe, Standar" style="border-radius: var(--radius-buttons);">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6 mb-3">
                                                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Tarif Khusus (Opsional)</label>
                                                                        <input type="number" name="price_override" class="form-control" value="{{ old('price_override', $room->price_override) }}" placeholder="Default: Rp {{ number_format($kos->price, 0, ',', '.') }}" style="border-radius: var(--radius-buttons);">
                                                                    </div>
                                                                    <div class="col-6 mb-3">
                                                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Status Kamar <span class="text-danger">*</span></label>
                                                                        <select name="status" class="form-select" required style="border-radius: var(--radius-buttons);">
                                                                            <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>Tersedia</option>
                                                                            <option value="occupied" {{ $room->status === 'occupied' ? 'selected' : '' }}>Terisi</option>
                                                                            <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" style="font-size: 13px; font-weight: 600;">Catatan / Deskripsi Kamar</label>
                                                                    <textarea name="description" class="form-control" rows="2" style="border-radius: var(--radius-buttons);" placeholder="Keterangan posisi, jendela, fasilitas khusus...">{{ old('description', $room->description) }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer" style="border-top: var(--border-hairline);">
                                                                <button type="button" class="btn btn-sm" data-bs-dismiss="modal" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border-radius: var(--radius-buttons);">Batal</button>
                                                                <button type="submit" class="btn btn-sm" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; border-radius: var(--radius-buttons); border: none;">Simpan Perubahan</button>
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
                @else
                    <div class="p-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; border-radius: 50%; background-color: var(--surface-page-canvas); color: var(--color-stone); font-size: 24px;">
                            <i class="fa fa-door-closed"></i>
                        </div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                            Belum Ada Kamar Terdaftar
                        </h3>
                        <p style="font-size: 13.5px; color: var(--color-stone); max-width: 440px; margin: 0 auto 20px;">
                            Daftarkan kamar individual untuk memudahkan pencatatan ketersediaan, nomor kamar penyewa, dan status hunian.
                        </p>
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modalAddRoom" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13px; padding: 9px 18px; border-radius: var(--radius-buttons); border: none;">
                            <i class="fa fa-plus-circle mr-1"></i> Tambah Kamar Pertama
                        </button>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>

<!-- MODAL ADD ROOM -->
<div class="modal fade" id="modalAddRoom" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: var(--radius-cards); border: var(--border-hairline);">
            <form action="{{ route('owner.kos.rooms.store', $kos->slug) }}" method="POST">
                @csrf
                <div class="modal-header" style="border-bottom: var(--border-hairline);">
                    <h5 class="modal-title" style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink);">
                        Tambah Kamar Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Nomor / Kode Kamar <span class="text-danger">*</span></label>
                        <input type="text" name="room_number" class="form-control" placeholder="Contoh: A-01, 101, B-03" required style="border-radius: var(--radius-buttons);">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label" style="font-size: 13px; font-weight: 600;">Lantai</label>
                            <input type="text" name="floor" class="form-control" placeholder="Contoh: Lantai 1" style="border-radius: var(--radius-buttons);">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" style="font-size: 13px; font-weight: 600;">Tipe Kamar</label>
                            <input type="text" name="room_type" class="form-control" placeholder="Contoh: Standar, Deluxe" style="border-radius: var(--radius-buttons);">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label" style="font-size: 13px; font-weight: 600;">Tarif Khusus (Opsional)</label>
                            <input type="number" name="price_override" class="form-control" placeholder="Default: Rp {{ number_format($kos->price, 0, ',', '.') }}" style="border-radius: var(--radius-buttons);">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" style="font-size: 13px; font-weight: 600;">Status Kamar <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required style="border-radius: var(--radius-buttons);">
                                <option value="available" selected>Tersedia</option>
                                <option value="occupied">Terisi</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Catatan / Deskripsi Kamar</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Keterangan posisi, jendela, fasilitas khusus..." style="border-radius: var(--radius-buttons);"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: var(--border-hairline);">
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border-radius: var(--radius-buttons);">Batal</button>
                    <button type="submit" class="btn btn-sm" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; border-radius: var(--radius-buttons); border: none;">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
