@extends('layouts.app')

@section('title', 'Cari Kos - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')

    <main id="ts-main">

        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cari Kos</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section id="page-title">
            <div class="container">
                <div class="ts-title mb-0">
                    <h1>Cari Kos</h1>
                    <h5 class="ts-opacity__90">Temukan kos impianmu di seluruh Indonesia dengan pencarian yang mudah.</h5>
                </div>
            </div>
        </section>

        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <aside class="card p-4 shadow-sm">
                            <h3 class="h5 mb-3">Filter Pencarian</h3>
                            <form action="{{ route('search.kos') }}" method="GET">
                                <div class="form-group">
                                    <label for="keyword">Kata Kunci</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Kota, alamat, atau nama kos">
                                </div>
                                <div class="form-group">
                                    <label for="type">Tipe Kos</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="">Semua</option>
                                        <option value="putra">Putra</option>
                                        <option value="putri">Putri</option>
                                        <option value="campur">Campur</option>
                                        <option value="eksklusif">Eksklusif</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="city">Kota</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Contoh: Surabaya">
                                </div>
                                <div class="form-group">
                                    <label for="max_price">Harga Maksimal</label>
                                    <input type="number" class="form-control" id="max_price" name="max_price" placeholder="Contoh: 1000000">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Cari Kos</button>
                            </form>
                        </aside>
                    </div>

                    <div class="col-lg-8">
                        <div class="row">
                            @forelse($listKos as $kos)
                            <div class="col-12 mb-4">
                                <div class="card ts-item ts-item__list ts-card h-100">
                                    <div class="ts-ribbon"><i class="fa fa-thumbs-up"></i></div>
                                    <a href="{{ route('kos.show', $kos['slug']) }}" class="card-img ts-item__image" data-bg-image="{{ asset($kos['thumbnail']) }}"></a>

                                    <div class="card-body ts-item__body">
                                        <figure class="ts-item__info">
                                            <div class="ts-card__meta">
                                                <span class="ts-card__type">{{ $kos['type'] }}</span>
                                                <span class="ts-card__rating"><i class="fa fa-star"></i> {{ number_format($kos['rating'] ?? 0, 1) }}</span>
                                                <span class="ts-card__availability">Sisa {{ $kos['available_rooms'] ?? 0 }} kamar</span>
                                            </div>
                                            <h4>{{ $kos['title'] }}</h4>
                                            <aside><i class="fa fa-map-marker mr-2"></i>{{ $kos['city'] }}</aside>
                                        </figure>

                                        <div class="ts-item__info-badge">Rp {{ number_format($kos['price'], 0, ',', '.') }} /bln</div>

                                        <div class="ts-description-lists">
                                            <dl><dt>Tipe</dt><dd>{{ $kos['type'] }}</dd></dl>
                                            <dl><dt>Kamar</dt><dd>{{ $kos['bedrooms'] ?? '1' }}</dd></dl>
                                            <dl><dt>K. Mandi</dt><dd>{{ $kos['bathrooms'] ?? 'Dalam' }}</dd></dl>
                                        </div>
                                    </div>

                                    <a href="{{ route('kos.show', $kos['slug']) }}" class="card-footer ts-item__footer">
                                        <span class="ts-btn-arrow">Lihat Detail</span>
                                    </a>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="ts-box text-center py-5">
                                    <p class="text-muted mb-0">Belum ada kos yang tersedia saat ini.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
