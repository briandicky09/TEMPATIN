@extends('layouts.owner')

@section('title', 'Laporan Statistik - TEMPATIN')

@section('owner-content')
<main id="ts-main">
    <section class="py-5">
        <div class="container">
            <div class="mb-4">
                <span class="text-primary font-weight-bold text-uppercase small">Laporan Owner</span>
                <h2 class="mb-1 mt-1">Laporan Statistik</h2>
                <p class="text-muted mb-0">Pantau performa bisnis kos Anda dalam satu ringkasan.</p>
            </div>

            <div class="row mb-4">
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted small mb-2"><i class="fa fa-money mr-1 text-success"></i>Total Pendapatan</p>
                            <h4 class="mb-0">Rp {{ number_format($summary['pendapatan'], 0, ',', '.') }}</h4>
                            <small class="text-success"><i class="fa fa-arrow-up mr-1"></i>{{ $summary['pertumbuhan'] }}% dari bulan lalu</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted small mb-2"><i class="fa fa-calendar-check-o mr-1 text-primary"></i>Total Booking</p>
                            <h4 class="mb-0">{{ $summary['booking'] }}</h4>
                            <small class="text-muted">Booking tahun ini</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted small mb-2"><i class="fa fa-bed mr-1 text-warning"></i>Tingkat Hunian</p>
                            <h4 class="mb-0">{{ $summary['tingkat_hunian'] }}%</h4>
                            <small class="text-muted">Rata-rata seluruh kos</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted small mb-2"><i class="fa fa-home mr-1 text-info"></i>Properti Aktif</p>
                            <h4 class="mb-0">2 <small class="text-muted">/ 3 kos</small></h4>
                            <small class="text-muted">Kos yang sedang aktif</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="mb-1">Pendapatan Bulanan</h5>
                                    <small class="text-muted">6 bulan terakhir</small>
                                </div>
                                <span class="badge badge-light text-primary px-3 py-2">2026</span>
                            </div>
                            @php($maxRevenue = max(array_column($monthlyRevenue, 'value')))
                            @foreach($monthlyRevenue as $revenue)
                                <div class="d-flex align-items-center mb-3">
                                    <span class="text-muted small" style="width: 35px;">{{ $revenue['month'] }}</span>
                                    <div class="progress flex-grow-1" style="height: 10px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($revenue['value'] / $maxRevenue) * 100 }}%;" aria-label="Pendapatan {{ $revenue['month'] }}"></div>
                                    </div>
                                    <span class="small font-weight-bold text-right ml-3" style="width: 100px;">Rp {{ number_format($revenue['value'] / 1000000, 1, ',', '.') }} jt</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="mb-1">Performa Kos</h5>
                            <small class="text-muted d-block mb-4">Berdasarkan tingkat hunian</small>
                            @foreach($kosPerformance as $kos)
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong class="small">{{ $kos['title'] }}</strong>
                                        <span class="small text-success font-weight-bold">{{ $kos['occupancy'] }}%</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $kos['occupancy'] }}%;" aria-label="Hunian {{ $kos['title'] }}"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0">Detail Performa Properti</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th class="pl-4">Nama Kos</th>
                                    <th>Tingkat Hunian</th>
                                    <th>Booking</th>
                                    <th class="pr-4">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kosPerformance as $kos)
                                    <tr>
                                        <td class="pl-4"><strong>{{ $kos['title'] }}</strong></td>
                                        <td><span class="badge badge-success">{{ $kos['occupancy'] }}%</span></td>
                                        <td>{{ $kos['booking'] }} booking</td>
                                        <td class="pr-4">Rp {{ number_format($kos['revenue'], 0, ',', '.') }}</td>
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
