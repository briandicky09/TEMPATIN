@extends('layouts.owner')

@section('title', 'Detail Kos - TEMPATIN')

@section('owner-content')
<main id="ts-main">
    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h4 class="mb-1 font-weight-bold text-dark">Detail Kos</h4>
                            <p class="text-muted mb-0">Informasi lengkap properti kos Anda.</p>
                        </div>
                        <a href="{{ route('owner.kos.my') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <img src="{{ asset($kos['thumbnail']) }}" alt="{{ $kos['title'] }}" class="img-fluid rounded mb-3" style="height: 320px; object-fit: cover; width: 100%;">
                            <h5 class="font-weight-bold">{{ $kos['title'] }}</h5>
                            <p class="text-muted">{{ $kos['city'] }} • {{ ucfirst($kos['type']) }}</p>
                            <p>{{ $kos['description'] ?? 'Deskripsi kos belum tersedia.' }}</p>

                            <div class="border rounded p-3 mt-4">
                                <h6 class="font-weight-bold mb-3"><i class="fa fa-list-ul mr-2 text-primary"></i>Fasilitas Kos</h6>
                                @if(isset($kos->facilities) && $kos->facilities->isNotEmpty())
                                    <div class="d-flex flex-wrap">
                                        @foreach($kos->facilities as $facility)
                                            <span class="badge badge-light border text-dark mr-2 mb-2 p-2" style="font-size: 0.85rem; font-weight: 500;">
                                                <i class="fa fa-check text-success mr-1"></i>{{ $facility->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0"><small>Belum ada fasilitas yang ditambahkan.</small></p>
                                @endif
                            </div>

                            <div class="border rounded p-3 mt-4">
                                <h6 class="font-weight-bold mb-3"><i class="fa fa-images mr-2 text-primary"></i>Galeri Foto Kos</h6>
                                @if(isset($kos->photos) && $kos->photos->isNotEmpty())
                                    <div class="row">
                                        @foreach($kos->photos as $photo)
                                            <div class="col-6 col-sm-4 col-md-3 mb-3">
                                                <div class="card h-100 border shadow-none overflow-hidden">
                                                    <a href="{{ $photo->url }}" target="_blank">
                                                        <img src="{{ $photo->url }}" alt="Foto Kos" class="card-img-top" style="height: 120px; object-fit: cover;">
                                                    </a>
                                                    <div class="card-body p-1 text-center bg-light">
                                                        <small class="text-muted">Foto #{{ $loop->iteration }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0"><small>Belum ada foto galeri yang ditambahkan.</small></p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="border rounded p-3 mb-3">
                                <h6 class="font-weight-bold">Informasi Harga</h6>
                                <p class="mb-1"><strong>Rp {{ number_format($kos['price'], 0, ',', '.') }}</strong>/bulan</p>
                                <p class="mb-0"><span class="badge {{ ($kos['status'] === 'active' || $kos['status'] === 'Aktif') ? 'badge-success' : 'badge-secondary' }}">{{ $kos['status'] === 'active' ? 'Aktif' : ($kos['status'] === 'inactive' ? 'Nonaktif' : $kos['status']) }}</span></p>
                            </div>
                            <div class="border rounded p-3">
                                <h6 class="font-weight-bold">Aksi</h6>
                                <a href="{{ route('owner.kos.edit', $kos['slug']) }}" class="btn btn-outline-primary btn-sm mb-2 d-block">Edit Kos</a>
                                <form action="{{ route('owner.kos.destroy', $kos['slug']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kos ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm d-block w-100">Hapus Kos</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
