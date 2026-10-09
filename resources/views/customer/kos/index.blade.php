@extends('layouts.customer')

@section('title', 'Kos Saya - TEMPATIN')

@section('customer-content')

<div class="row mb-4">
    <div class="col-12">
        <h4 class="font-weight-bold text-dark mb-0">Kos yang Sedang Disewa</h4>
    </div>
</div>

<div class="row">
    @forelse($rentedKos as $kos)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 8px; overflow: hidden;">
            <img src="{{ asset($kos['thumbnail']) }}" class="card-img-top" alt="Foto Kos" style="height: 200px; object-fit: cover; background-color: #ccc;">
            <div class="card-body">
                <span class="badge text-white mb-2 px-2 py-1" style="background-color: #0000ff;">Kos {{ $kos['type'] }}</span>
                <h5 class="card-title font-weight-bold mb-1 text-dark">{{ $kos['title'] }}</h5>
                <p class="text-muted ts-text-small mb-2"><i class="fa fa-map-marker-alt mr-1"></i> {{ $kos['city'] }}</p>
                <p class="text-muted ts-text-small mb-3"><i class="fa fa-calendar mr-1"></i> {{ $kos['periode'] }}</p>
                <h5 class="font-weight-bold text-dark mb-0">Rp {{ number_format($kos['price'], 0, ',', '.') }} <span class="text-muted font-weight-normal ts-text-small">/ bulan</span></h5>
            </div>
            <div class="card-footer bg-white border-top-0 pb-4 pt-0">
                <a href="{{ route('kos.show', $kos['slug']) }}" class="btn btn-outline-dark w-100 font-weight-bold" style="border-radius: 4px;">Lihat Detail</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm p-5 text-center">
            <p class="text-muted mb-3">Kamu belum menyewa kos apa pun saat ini.</p>
            <a href="{{ route('search.kos') }}" class="btn btn-primary">Cari Kos Sekarang</a>
        </div>
    </div>
    @endforelse
</div>

@endsection
