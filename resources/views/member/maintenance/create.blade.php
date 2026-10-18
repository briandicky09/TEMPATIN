@extends('layouts.app')

@section('title', 'Buat Laporan Kerusakan - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 15px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('member.maintenance.index') }}" style="color: var(--color-stone); text-decoration: none;">Laporan Kerusakan</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Buat Laporan Baru</li>
                </ol>
            </nav>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- HEADER -->
                    <div class="mb-4">
                        <span class="badge px-3 py-1 font-weight-normal mb-1" style="border-radius: 9999px; background-color: var(--color-sky-tint); color: var(--color-ink-black); border: 1px solid rgba(0, 117, 222, 0.2);">
                            <i class="fa fa-tools mr-1"></i> TIKET PEMELIHARAAN
                        </span>
                        <h2 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">
                            Laporkan Kerusakan Fasilitas
                        </h2>
                        <p class="text-muted small mb-0">
                            Jelaskan masalah fasilitas kamar kos Anda agar pemilik properti dapat segera mengambil tindakan perbaikan.
                        </p>
                    </div>

                    <!-- FORM CARD -->
                    <div class="card" style="border: var(--border-hairline); border-radius: 14px; background: #ffffff; box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden;">
                        <div class="card-body p-4 p-md-5">

                            <form action="{{ route('member.maintenance.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Pilih Hunian / Booking -->
                                <div class="form-group mb-3">
                                    <label for="booking_id" class="font-weight-600 small text-dark">Pilih Kamar / Hunian <span class="text-danger">*</span></label>
                                    <select class="form-control" id="booking_id" name="booking_id" required style="border-radius: 8px;">
                                        @foreach($activeBookings as $b)
                                            <option value="{{ $b->id }}">
                                                {{ $b->kos->title }} - {{ $b->room ? ('Kamar #' . $b->room->room_number) : 'Kamar Standar' }} (Kode: {{ $b->booking_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Judul Kerusakan -->
                                <div class="form-group mb-3">
                                    <label for="title" class="font-weight-600 small text-dark">Judul Kerusakan / Kendala <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required
                                        placeholder="Contoh: AC tidak dingin / Wastafel kamar mandi mampet"
                                        style="border-radius: 8px;" value="{{ old('title') }}">
                                </div>

                                <!-- Deskripsi -->
                                <div class="form-group mb-3">
                                    <label for="description" class="font-weight-600 small text-dark">Deskripsi Rinci <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required
                                        placeholder="Jelaskan secara detail apa yang terjadi, sejak kapan kendala timbul, dan dampaknya pada kenyamanan Anda."
                                        style="border-radius: 8px;">{{ old('description') }}</textarea>
                                </div>

                                <!-- Upload Foto Bukti -->
                                <div class="form-group mb-4">
                                    <label for="photo" class="font-weight-600 small text-dark">Foto Bukti Kerusakan (Opsional)</label>
                                    <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG, WEBP. Maksimal 3MB.</small>
                                </div>

                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <a href="{{ route('member.maintenance.index') }}" class="btn btn-outline-secondary font-weight-600" style="border-radius: 8px;">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px;">
                                        <i class="fa fa-paper-plane mr-2"></i>Kirim Laporan Kerusakan
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>

    @include('partials.footer')

</div>
@endsection
