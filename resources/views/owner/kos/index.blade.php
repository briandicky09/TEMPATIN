@extends('layouts.owner')

@section('title', 'Cari Kos - TEMPATIN')

@section('owner-content')
<main id="ts-main">

    

        <!-- ITEMS AND SIDEBAR
            =========================================================================================================-->
        <section id="items-grid-and-sidebar">
            <div class="container">
                <div class="row">

                    <!--LEFT SIDE (SIDEBAR)
                        =============================================================================================-->
                    <div class="col-md-4 navbar-expand-md">

                        <button class="btn bg-white mb-4 w-100 d-block d-md-none" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="float-left">
                                    <i class="fa fa-search mr-2"></i>
                                    Redefine Search
                                </span>
                            <span class="float-right">
                                    <i class="fa fa-plus small ts-opacity__30"></i>
                                </span>
                        </button>

                        <aside id="sidebar" class="ts-sidebar collapse navbar-collapse">

                            <!--SEARCH FORM
                                =========================================================================================-->
                            <section id="sidebar-search-form">

                                <h3>Cari Kos</h3>

                                <form action="{{ route('search.kos') }}" method="GET">

                                    <div class="form-group mb-3">
                                        <label class="ts-text-small font-weight-bold text-muted mb-2">Lokasi atau Nama Kos</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0"><i class="fa fa-map-marker-alt text-muted"></i></span>
                                            </div>
                                            <input type="text" class="form-control border-left-0 pl-0" name="keyword" placeholder="Contoh: Surabaya, Sidoarjo..." style="padding: 12px 15px;" value="{{ request('keyword') }}">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="ts-text-small font-weight-bold text-muted mb-2">Tipe Kos</label>
                                        <select class="form-control" name="type" style="height: auto; padding: 12px 15px;">
                                            <option value="">Semua Tipe</option>
                                            <option value="putra" {{ request('type') === 'putra' ? 'selected' : '' }}>Putra</option>
                                            <option value="putri" {{ request('type') === 'putri' ? 'selected' : '' }}>Putri</option>
                                            <option value="campur" {{ request('type') === 'campur' ? 'selected' : '' }}>Campur</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="ts-text-small font-weight-bold text-muted mb-2">Rentang Harga</label>
                                        <select class="form-control" name="price" style="height: auto; padding: 12px 15px;">
                                            <option value="">Semua Harga</option>
                                            <option value="murah" {{ request('price') === 'murah' ? 'selected' : '' }}>< Rp 1.000.000</option>
                                            <option value="menengah" {{ request('price') === 'menengah' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                                            <option value="mahal" {{ request('price') === 'mahal' ? 'selected' : '' }}>> Rp 2.000.000</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn text-white w-100 font-weight-bold" style="background-color: #0000ff; border-color: #0000ff; padding: 12px 0;">
                                        <i class="fa fa-search mr-2"></i>Cari
                                    </button>

                                </form>
                                <!--end #form-search-->
                            </section>
                            <!--end #sidebar-search-form-->

                            <section id="map-results">
                                <h3>Map Results</h3>

                                <div id="ts-map-simple" class="ts-sidebar-map"
                                     data-ts-map-leaflet-provider="https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png"
                                     data-ts-map-zoom="12"
                                     data-ts-map-center-latitude="40.702411"
                                     data-ts-map-center-longitude="-73.556842"
                                     data-ts-map-scroll-wheel="1"
                                     data-ts-map-controls="0"></div>

                            </section>

                        </aside>
                        <!--end #sidebar-->
                    </div>
                    <!--end Left Side / col-md-4-->

                    <!--RIGHT SIDE (ITEMS)
                        =============================================================================================-->
                    <div class="col-md-8">

                        <!--DISPLAY CONTROL
                            =========================================================================================-->
                        <section id="display-control" class="clearfix mb-4">

                            <div class="float-left">
                                <a href="#" class="btn btn-outline-secondary active px-3 mr-2 mb-2 ts-btn-border-muted">
                                    <i class="fa fa-th-large"></i>
                                </a>
                                <a href="#" class="btn btn-outline-secondary px-3 mb-2 ts-btn-border-muted">
                                    <i class="fa fa-th-list"></i>
                                </a>
                            </div>

                            <div class="float-none float-sm-right pl-2 ts-center__vertical">
                                <label for="sorting" class="mb-0 mr-2 text-nowrap">Sort by:</label>
                                <select class="custom-select bg-transparent" id="sorting" name="sorting">
                                    <option value="">Default</option>
                                    <option value="1">Harga Terendah</option>
                                    <option value="2">Harga Tertinggi</option>
                                    <option value="3">Jarak</option>
                                </select>
                            </div>

                        </section>

                        <!--ITEMS LIST
                            =========================================================================================-->
                        <section id="ts-items-list">

                            @foreach($listKos as $kos)
                            <div class="card ts-item ts-item__list ts-card mb-4">

                                <div class="ts-ribbon">{{ $kos['status'] === 'Aktif' ? 'Hot' : 'New' }}</div>

                                <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="card-img ts-item__image" data-bg-image="{{ asset($kos['thumbnail']) }}"></a>

                                <div class="card-body ts-item__body">

                                    <figure class="ts-item__info">
                                        <h4>{{ $kos['title'] }}</h4>
                                        <aside><i class="fa fa-map-marker mr-2"></i>{{ $kos['city'] }}</aside>
                                    </figure>

                                    <div class="ts-item__info-badge">Rp {{ number_format($kos['price'], 0, ',', '.') }}</div>

                                    <div class="ts-description-lists">
                                        <dl><dt>Tipe</dt><dd>{{ ucfirst($kos['type']) }}</dd></dl>
                                        <dl><dt>Kamar</dt><dd>1</dd></dl>
                                        <dl><dt>K. Mandi</dt><dd>Dalam</dd></dl>
                                    </div>
                                </div>

                                <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="card-footer ts-item__footer">
                                    <span class="ts-btn-arrow">Detail</span>
                                </a>

                            </div>
                            @endforeach

                        </section>
                        <!--end #ts-items-list-->

                        <!--PAGINATION
                            =========================================================================================-->
                        <section id="pagination">
                            <div class="container">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination ts-center__horizontal">
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link ts-btn-arrow" href="#">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </section>

                    </div>
                    <!--end Right Side / col-md-8-->

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>
        <!--end #items-grid-and-sidebar-->

    </main>
    <!--end #ts-main-->
@endsection
