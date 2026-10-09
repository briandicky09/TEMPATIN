@extends('layouts.owner')

@section('title', 'Penilaian Kos - TEMPATIN')

@section('owner-content')
<main id="ts-main">
    <section class="py-5">
        <div class="container">
            <div class="mb-4">
                <span class="text-primary font-weight-bold text-uppercase small">Manajemen Kos</span>
                <h2 class="mb-1 mt-1">Penilaian Kos</h2>
                <p class="text-muted mb-0">Pantau pengalaman penghuni melalui penilaian dan ulasan terbaru.</p>
            </div>

            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card ts-card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-warning p-3 mr-3">
                                <i class="fa fa-star text-white fa-lg"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Rata-rata penilaian</div>
                                <div class="h3 mb-0 font-weight-bold">{{ number_format($rataRating, 1, ',', '.') }} <small class="text-muted">/ 5</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card ts-card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-primary p-3 mr-3">
                                <i class="fa fa-comments text-white fa-lg"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Total ulasan</div>
                                <div class="h3 mb-0 font-weight-bold">{{ $totalUlasan }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card ts-card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-success p-3 mr-3">
                                <i class="fa fa-building text-white fa-lg"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Kos dinilai</div>
                                <div class="h3 mb-0 font-weight-bold">{{ count($ratings) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card ts-card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 font-weight-bold">Ringkasan Penilaian</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th class="pl-4">Nama Kos</th>
                                    <th>Rating</th>
                                    <th>Jumlah Ulasan</th>
                                    <th>Ulasan Terbaru</th>
                                    <th class="pr-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ratings as $rating)
                                    <tr>
                                        <td class="pl-4">
                                            <strong>{{ $rating['kos'] }}</strong>
                                            <div class="small text-muted">Penilaian penghuni</div>
                                        </td>
                                        <td>
                                            <div class="text-warning text-nowrap">
                                                @for($star = 1; $star <= 5; $star++)
                                                    <i class="fa fa-star{{ $star <= round($rating['rating']) ? '' : '-o' }}"></i>
                                                @endfor
                                                <strong class="text-dark ml-1">{{ number_format($rating['rating'], 1, ',', '.') }}</strong>
                                            </div>
                                        </td>
                                        <td>{{ $rating['total'] }} ulasan</td>
                                        <td class="text-muted" style="min-width: 280px;">
                                            <div class="text-dark">&ldquo;{{ $rating['latest'] }}&rdquo;</div>
                                            <small>{{ $rating['reviewer'] }} &middot; {{ $rating['date'] }}</small>
                                        </td>
                                        <td class="pr-4">
                                            <a href="{{ route('owner.kos.show', $rating['slug']) }}" class="btn btn-sm btn-outline-primary text-nowrap">Lihat Kos</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
