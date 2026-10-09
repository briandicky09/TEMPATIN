@extends('layouts.owner')

@section('title', 'Dashboard Owner - TEMPATIN')

@section('owner-content')
<main id="ts-main">
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="mb-1">Dashboard Owner</h2>
                    <p class="text-muted mb-0">Ringkasan performa properti kos Anda.</p>
                </div>
                <a href="{{ route('owner.kos.create') }}" class="btn btn-primary">+ Tambah Kos</a>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">Total Kos</p>
                            <h3 class="mb-0">{{ $totalKos }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">Kos Aktif</p>
                            <h3 class="mb-0 text-success">{{ $kosAktif }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">Kos Nonaktif</p>
                            <h3 class="mb-0 text-secondary">{{ $kosNonaktif }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">Rata-rata Harga</p>
                            <h5 class="mb-0">Rp {{ number_format($rataHarga, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Kos Terbaru</h5>
                        <a href="{{ route('owner.kos.my') }}" class="btn btn-sm btn-outline-primary">Kelola Kos</a>
                    </div>

                    <div class="row">
                        @foreach($recentKos as $kos)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 border">
                                    <img src="{{ asset($kos['thumbnail']) }}" class="card-img-top" alt="{{ $kos['title'] }}" style="height: 180px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="mb-2">{{ $kos['title'] }}</h6>
                                        <p class="text-muted small mb-1"><i class="fa fa-map-marker-alt mr-1"></i>{{ $kos['city'] }}</p>
                                        <p class="mb-0"><strong>Rp {{ number_format($kos['price'], 0, ',', '.') }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
