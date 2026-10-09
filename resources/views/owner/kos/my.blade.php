@extends('layouts.owner')

@section('title', 'Kos Saya - TEMPATIN')

@section('owner-content')
<main id="ts-main">
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Kos Saya</h2>
                    <p class="text-muted mb-0">Kelola semua properti kos yang Anda miliki.</p>
                </div>
                <a href="{{ route('owner.kos.create') }}" class="btn btn-primary">+ Tambah Kos</a>
            </div>

            <div class="row">
                @foreach($listKos as $kos)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset($kos['thumbnail']) }}" class="card-img-top" alt="{{ $kos['title'] }}" style="height: 220px; object-fit: cover;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $kos['title'] }}</h5>
                                    <span class="badge {{ ($kos['status'] === 'Aktif' || $kos['status'] === 'active') ? 'badge-success' : 'badge-secondary' }}">{{ $kos['status'] === 'active' ? 'Aktif' : ($kos['status'] === 'inactive' ? 'Nonaktif' : $kos['status']) }}</span>
                                </div>
                                <p class="text-muted small mb-2"><i class="fa fa-map-marker-alt mr-2"></i>{{ $kos['city'] }}</p>
                                <p class="mb-2"><strong>Rp {{ number_format($kos['price'], 0, ',', '.') }}</strong></p>
                                <p class="text-muted small mb-0">Tipe: {{ ucfirst($kos['type']) }}</p>
                            </div>
                            <div class="card-footer bg-white border-0 pt-0">
                                <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection
