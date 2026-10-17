@extends('layouts.owner')

@section('title', 'Tambah Kos Baru - TEMPATIN')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #owner-map-picker {
        z-index: 1;
    }
    #owner-map-picker .leaflet-control-zoom {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        border-radius: 8px;
        overflow: hidden;
        margin: 10px;
    }
    #owner-map-picker .leaflet-control-zoom a {
        background-color: #ffffff;
        color: #2f3437;
        font-size: 14px;
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-bottom: 1px solid #f0f0f0;
    }
    #owner-map-picker .leaflet-control-zoom a:hover {
        background-color: #f7f6f3;
        color: #0075de;
    }
</style>
@endpush

@section('owner-content')
<div class="container">
    <div class="row">

        <!-- OWNER SIDEBAR -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            @include('partials.owner-sidebar')
        </div>

        <!-- MAIN FORM CONTENT -->
        <div class="col-lg-9">

            <!-- HEADER -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-ink-black); font-size: 11px; font-weight: 600;">
                        <i class="fa fa-plus-circle mr-1"></i> REGISTRASI HUNIAN BARU
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Tambah Kos Baru
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Lengkapi rincian spesifikasi kamar, lokasi, fasilitas, dan foto untuk menarik minat calon penyewa.
                    </p>
                </div>
                <div>
                    <a href="{{ route('owner.kos.my') }}" class="btn btn-sm" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 8px 16px;">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- FORM WRAPPER -->
            <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <form id="form-create-kos" method="POST" action="{{ route('owner.kos.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- SECTION 1: INFORMASI DASAR -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-ink-black); border: 1px solid rgba(0, 117, 222, 0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">1</span>
                            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Informasi Properti</h2>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Nama Kos <span style="color: var(--color-notion-blue);">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="cth. Kos Putri Melati Kampus C" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Tipe Kos <span style="color: var(--color-notion-blue);">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror" name="type" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; height: 44px; padding: 0 14px;">
                                    <option value="">Pilih Tipe Kos...</option>
                                    <option value="Putra" {{ old('type') === 'Putra' ? 'selected' : '' }}>Kos Putra</option>
                                    <option value="Putri" {{ old('type') === 'Putri' ? 'selected' : '' }}>Kos Putri</option>
                                    <option value="Campur" {{ old('type') === 'Campur' ? 'selected' : '' }}>Kos Campur</option>
                                    <option value="Eksklusif" {{ old('type') === 'Eksklusif' ? 'selected' : '' }}>Kos Eksklusif</option>
                                </select>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Kota / Kabupaten <span style="color: var(--color-notion-blue);">*</span></label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" placeholder="cth. Surabaya" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Harga Sewa / Bulan (Rp) <span style="color: var(--color-notion-blue);">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" placeholder="850000" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Alamat Lengkap</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" placeholder="cth. Jl. Mulyorejo No. 45, RT 02 / RW 05" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 form-group mb-0">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div>
                                        <label class="mb-0" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">
                                            <i class="fa fa-map-marked-alt mr-1" style="color: var(--color-notion-blue);"></i> Pilih Titik Lokasi dari Peta
                                        </label>
                                        <small class="text-muted d-block" style="font-size: 11.5px;">Cari alamat atau langsung klik pada peta untuk meletakkan pin lokasi kos.</small>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" id="btn-use-gps" class="btn btn-sm" style="background-color: var(--surface-page-canvas); border: var(--border-hairline); font-size: 11.5px; font-weight: 600; color: var(--color-midnight-ink); padding: 5px 12px; border-radius: 6px;">
                                            <i class="fa fa-crosshairs mr-1 text-primary"></i> Gunakan Lokasi Saat Ini
                                        </button>
                                        <button type="button" id="btn-clear-coords" class="btn btn-sm text-danger" style="background-color: var(--surface-page-canvas); border: var(--border-hairline); font-size: 11.5px; font-weight: 600; padding: 5px 12px; border-radius: 6px; display: none;">
                                            <i class="fa fa-times mr-1"></i> Hapus Titik
                                        </button>
                                    </div>
                                </div>

                                <!-- MAP SEARCH BOX -->
                                <div class="input-group mb-2" style="max-width: 100%;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: #ffffff; border: var(--border-hairline); border-right: none; border-radius: 8px 0 0 8px; font-size: 13px; color: var(--color-stone);">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" id="map-search-input" class="form-control" placeholder="Ketik nama jalan, tempat, atau daerah (cth: Rungkut Madya, Surabaya)..." style="border: var(--border-hairline); border-left: none; border-right: none; font-size: 13px;">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="btn-search-map" style="border-radius: 0 8px 8px 0; font-size: 12.5px; font-weight: 600; padding: 0 16px;">
                                            <i class="fa fa-search mr-1"></i> Cari di Peta
                                        </button>
                                    </div>
                                </div>

                                <!-- INTERACTIVE MAP CONTAINER -->
                                <div class="position-relative mb-2" style="border: var(--border-hairline); border-radius: 12px; overflow: hidden; height: 320px; background-color: #f7f6f3; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                                    <div id="owner-map-picker" style="width: 100%; height: 100%;"></div>
                                </div>

                                <!-- STATUS & READOUT -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center" style="font-size: 12px;">
                                    <span id="coords-status" class="text-muted">
                                        <i class="fa fa-info-circle mr-1"></i> Klik pada peta atau geser pin untuk menentukan lokasi kos.
                                    </span>
                                    <span id="coords-readout" class="badge px-2 py-1" style="background-color: var(--color-sky-tint); color: var(--color-ink-black); border: 1px solid rgba(0, 117, 222, 0.2); font-size: 11.5px; font-weight: 600; border-radius: 6px; display: none;">
                                        Titik: <span id="coords-val">-</span>
                                    </span>
                                </div>

                                <!-- Hidden form inputs for coordinates -->
                                <input type="hidden" id="input-latitude" name="latitude" value="{{ old('latitude') }}">
                                <input type="hidden" id="input-longitude" name="longitude" value="{{ old('longitude') }}">
                                @error('latitude') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                @error('longitude') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: SPESIFIKASI & DETAIL UNIT -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-ink-black); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">2</span>
                            <div>
                                <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Spesifikasi & Detail Kamar</h2>
                                <small class="text-muted">Data ini akan ditampilkan di kartu Details pada halaman kos area member dan publik.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Luas Kamar (m²)</label>
                                <input type="text" class="form-control @error('area') is-invalid @enderror" name="area" value="{{ old('area') }}" placeholder="cth. 12 atau 3x4" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                <small class="text-muted d-block mt-1">Ukuran luas kamar (satuan m²).</small>
                                @error('area') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Jumlah Kamar</label>
                                <input type="text" class="form-control @error('rooms') is-invalid @enderror" name="rooms" value="{{ old('rooms') }}" placeholder="cth. 10 atau 1" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                <small class="text-muted d-block mt-1">Total kamar atau kapasitas unit.</small>
                                @error('rooms') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Kamar Mandi</label>
                                <input type="text" class="form-control @error('bathrooms') is-invalid @enderror" name="bathrooms" value="{{ old('bathrooms') }}" placeholder="cth. Dalam atau 1" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                <small class="text-muted d-block mt-1">Jenis kamar mandi (cth. Dalam, Luar, 1).</small>
                                @error('bathrooms') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3 mb-md-0">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Tempat Tidur</label>
                                <input type="text" class="form-control @error('bedrooms') is-invalid @enderror" name="bedrooms" value="{{ old('bedrooms') }}" placeholder="cth. 1 atau Single Bed" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                <small class="text-muted d-block mt-1">Tipe atau jumlah kasur / tempat tidur.</small>
                                @error('bedrooms') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-0">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Fasilitas Parkir</label>
                                <input type="text" class="form-control @error('garages') is-invalid @enderror" name="garages" value="{{ old('garages') }}" placeholder="cth. Motor & Mobil atau Motor" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                <small class="text-muted d-block mt-1">Akses parkir untuk penyewa.</small>
                                @error('garages') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: DESKRIPSI & THUMBNAIL -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-ink-black); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">3</span>
                            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Deskripsi & Foto Sampul</h2>
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Deskripsi Lengkap Kos</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4" placeholder="Ceritakan kelebihan kos: akses dekat kampus, lingkungan asri, jam malam fleksibel, dsb..." style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 12px 14px; line-height: 1.5;">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Foto Sampul Utama (Thumbnail)</label>
                            <input type="file" class="form-control-file @error('thumbnail') is-invalid @enderror" name="thumbnail" accept="image/*" style="font-size: 13px;">
                            <small class="text-muted d-block mt-1">Foto ini akan tampil sebagai kartu utama di hasil pencarian. Format: JPG, PNG, WEBP (Maks. 2MB).</small>
                            @error('thumbnail') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- SECTION 4: GALERI FOTO BANYAK -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-ink-black); border: 1px solid rgba(0, 117, 222, 0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">4</span>
                            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Galeri Foto Tambahan</h2>
                        </div>

                        <div class="form-group mb-3">
                            <label class="btn btn-sm d-inline-flex align-items-center mb-2" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 8px 16px; cursor: pointer;">
                                <i class="fa fa-images mr-2" style="color: var(--color-notion-blue);"></i> Pilih Banyak Foto Sekaligus
                                <input type="file" class="d-none" id="photos-input" name="photos[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
                            </label>
                            <span id="photos-count-label" class="text-muted small ml-2">Belum ada foto dipilih.</span>
                        </div>

                        @error('photos') <div class="alert alert-danger py-2 mb-3">{{ $message }}</div> @enderror
                        @error('photos.*') <div class="alert alert-danger py-2 mb-3">{{ $message }}</div> @enderror

                        <div id="photos-preview-container" class="row"></div>
                    </div>

                    <!-- SECTION 5: FASILITAS -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-ink-black); border: 1px solid rgba(0, 117, 222, 0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">5</span>
                            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Fasilitas Kos</h2>
                        </div>

                        <div class="row">
                            @forelse($facilities as $facility)
                                <div class="col-6 col-md-4 col-lg-3 mb-2">
                                    <label for="facility-{{ $facility->id }}" class="p-2 rounded d-flex align-items-center mb-0 cursor-pointer" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13px; font-weight: 500; cursor: pointer;">
                                        <input type="checkbox" id="facility-{{ $facility->id }}" name="facilities[]" value="{{ $facility->id }}" class="mr-2" {{ in_array($facility->id, old('facilities', [])) ? 'checked' : '' }} style="accent-color: var(--color-notion-blue);">
                                        <span style="color: var(--color-charcoal);">{{ $facility->name }}</span>
                                    </label>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted small mb-0">Belum ada fasilitas di database.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div class="pt-4 border-top d-flex gap-2" style="border-color: rgba(0,0,0,0.06) !important;">
                        <button type="submit" class="btn btn-primary" style="font-weight: 600; font-size: 14px; padding: 12px 28px; border-radius: var(--radius-buttons);">
                            <i class="fa fa-save mr-2"></i> Simpan Properti Kos
                        </button>
                        <a href="{{ route('owner.kos.my') }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-weight: 600; font-size: 14px; padding: 12px 20px; border-radius: var(--radius-buttons);">
                            Batal
                        </a>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // -------------------------------------------------------------
    // Leaflet Interactive Map Location Picker
    // -------------------------------------------------------------
    var mapContainer = document.getElementById('owner-map-picker');
    if (mapContainer && typeof L !== 'undefined') {
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        });

        var inputLat = document.getElementById('input-latitude');
        var inputLng = document.getElementById('input-longitude');
        var statusText = document.getElementById('coords-status');
        var readoutBox = document.getElementById('coords-readout');
        var readoutVal = document.getElementById('coords-val');
        var btnClear = document.getElementById('btn-clear-coords');
        var btnGps = document.getElementById('btn-use-gps');

        var currentLat = parseFloat(inputLat.value);
        var currentLng = parseFloat(inputLng.value);
        var hasInitial = !isNaN(currentLat) && !isNaN(currentLng);

        var defaultCenter = hasInitial ? [currentLat, currentLng] : [-7.2575, 112.7521];
        var defaultZoom = hasInitial ? 16 : 13;

        var map = L.map('owner-map-picker', {
            scrollWheelZoom: true
        }).setView(defaultCenter, defaultZoom);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = null;
        var reverseTimer = null;

        function fetchReverseAddress(lat, lng) {
            if (reverseTimer) clearTimeout(reverseTimer);
            reverseTimer = setTimeout(function () {
                fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng + '&zoom=18&addressdetails=1')
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        if (data && data.display_name) {
                            var shortAddress = data.display_name.split(',').slice(0, 3).join(', ');
                            statusText.innerHTML = '<span style="color: #15803d; font-weight: 500;"><i class="fa fa-map-pin mr-1"></i> ' + shortAddress + '</span>';
                            if (marker) {
                                marker.bindPopup('<b>Lokasi Terpilih</b><br><small>' + shortAddress + '</small>').openPopup();
                            }
                        }
                    })
                    .catch(function () {});
            }, 500);
        }

        function updateMarker(lat, lng, panTo) {
            lat = parseFloat(lat);
            lng = parseFloat(lng);
            if (isNaN(lat) || isNaN(lng)) return;

            inputLat.value = lat.toFixed(7);
            inputLng.value = lng.toFixed(7);

            readoutVal.textContent = lat.toFixed(5) + ', ' + lng.toFixed(5);
            readoutBox.style.display = 'inline-block';
            statusText.innerHTML = '<span style="color: #15803d; font-weight: 500;"><i class="fa fa-check-circle mr-1"></i> Titik lokasi terpilih. Pin dapat digeser langsung.</span>';
            if (btnClear) btnClear.style.display = 'inline-flex';

            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);

                marker.on('dragend', function (e) {
                    var pos = e.target.getLatLng();
                    updateMarker(pos.lat, pos.lng, false);
                });
            }

            fetchReverseAddress(lat, lng);

            if (panTo) {
                map.panTo([lat, lng]);
            }
        }

        if (hasInitial) {
            updateMarker(currentLat, currentLng, false);
        }

        map.on('click', function (e) {
            updateMarker(e.latlng.lat, e.latlng.lng, false);
        });

        // Search location directly on map
        var searchInput = document.getElementById('map-search-input');
        var btnSearch = document.getElementById('btn-search-map');

        function executeMapSearch() {
            var query = searchInput ? searchInput.value.trim() : '';
            if (!query || query.length < 3) {
                alert('Silakan ketik minimal 3 karakter untuk mencari alamat atau lokasi.');
                return;
            }

            var origHtml = btnSearch.innerHTML;
            btnSearch.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i> Mencari...';
            btnSearch.disabled = true;

            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&countrycodes=id&limit=5')
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    btnSearch.innerHTML = origHtml;
                    btnSearch.disabled = false;
                    if (data && data.length > 0) {
                        var first = data[0];
                        var sLat = parseFloat(first.lat);
                        var sLng = parseFloat(first.lon);
                        map.setView([sLat, sLng], 16);
                        updateMarker(sLat, sLng, false);
                    } else {
                        alert('Lokasi "' + query + '" tidak ditemukan. Coba gunakan nama jalan, landmark, atau kota yang lebih umum.');
                    }
                })
                .catch(function (err) {
                    btnSearch.innerHTML = origHtml;
                    btnSearch.disabled = false;
                    alert('Gagal mencari lokasi. Pastikan koneksi internet aktif.');
                });
        }

        if (btnSearch) {
            btnSearch.addEventListener('click', executeMapSearch);
        }

        if (searchInput) {
            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    executeMapSearch();
                }
            });
        }

        if (btnClear) {
            btnClear.addEventListener('click', function () {
                if (marker) {
                    map.removeLayer(marker);
                    marker = null;
                }
                inputLat.value = '';
                inputLng.value = '';
                readoutBox.style.display = 'none';
                statusText.innerHTML = '<i class="fa fa-info-circle mr-1"></i> Klik pada peta atau geser pin untuk menentukan lokasi kos.';
                btnClear.style.display = 'none';
            });
        }

        if (btnGps && navigator.geolocation) {
            btnGps.addEventListener('click', function () {
                btnGps.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i> Mendeteksi...';
                navigator.geolocation.getCurrentPosition(function (position) {
                    btnGps.innerHTML = '<i class="fa fa-crosshairs mr-1 text-primary"></i> Gunakan Lokasi Saat Ini';
                    var gLat = position.coords.latitude;
                    var gLng = position.coords.longitude;
                    map.setView([gLat, gLng], 16);
                    updateMarker(gLat, gLng, true);
                }, function (error) {
                    btnGps.innerHTML = '<i class="fa fa-crosshairs mr-1 text-primary"></i> Gunakan Lokasi Saat Ini';
                    alert('Tidak dapat mendeteksi lokasi: ' + error.message);
                }, { timeout: 10000 });
            });
        }

        var cityInput = document.querySelector('input[name="city"]');
        if (cityInput) {
            var cityCoordinates = {
                'surabaya': [-7.2575, 112.7521],
                'malang': [-7.9666, 112.6326],
                'jakarta': [-6.2088, 106.8456],
                'bandung': [-6.9175, 107.6191],
                'yogyakarta': [-7.7956, 110.3695],
                'jogja': [-7.7956, 110.3695],
                'semarang': [-6.9666, 110.4166],
                'solo': [-7.5755, 110.8243],
                'surakarta': [-7.5755, 110.8243],
                'denpasar': [-8.6705, 115.2126],
                'bali': [-8.4095, 115.1889],
                'medan': [3.5952, 98.6722],
                'makassar': [-5.1477, 119.4327],
                'palembang': [-2.9761, 104.7754]
            };

            cityInput.addEventListener('change', function () {
                if (!marker) {
                    var cityVal = this.value.trim().toLowerCase();
                    for (var key in cityCoordinates) {
                        if (cityVal.includes(key)) {
                            map.setView(cityCoordinates[key], 13);
                            break;
                        }
                    }
                }
            });
        }

        setTimeout(function () {
            map.invalidateSize();
        }, 300);

        window.addEventListener('resize', function () {
            map.invalidateSize();
        });
    }

    // -------------------------------------------------------------
    // Photos Multiple Upload Preview
    // -------------------------------------------------------------
    const input = document.getElementById('photos-input');
    const previewContainer = document.getElementById('photos-preview-container');
    const countLabel = document.getElementById('photos-count-label');

    if (!input || !previewContainer) return;

    let dt = new DataTransfer();

    input.addEventListener('change', function () {
        for (let i = 0; i < this.files.length; i++) {
            dt.items.add(this.files[i]);
        }
        this.files = dt.files;
        renderPreviews();
    });

    function renderPreviews() {
        previewContainer.innerHTML = '';
        const files = dt.files;

        if (files.length === 0) {
            countLabel.textContent = 'Belum ada foto dipilih.';
            return;
        }

        countLabel.textContent = files.length + ' foto dipilih.';

        Array.from(files).forEach((file, index) => {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4 col-lg-3 mb-3';

            const card = document.createElement('div');
            card.className = 'p-2 rounded text-center position-relative';
            card.style.backgroundColor = 'var(--surface-page-canvas)';
            card.style.border = 'var(--border-hairline)';

            const img = document.createElement('img');
            img.className = 'w-100 rounded mb-2';
            img.style.height = '110px';
            img.style.objectFit = 'cover';
            img.src = URL.createObjectURL(file);

            const nameSmall = document.createElement('small');
            nameSmall.className = 'd-block text-truncate mb-2';
            nameSmall.style.fontSize = '11px';
            nameSmall.style.color = 'var(--color-stone)';
            nameSmall.textContent = file.name;

            const btnRemove = document.createElement('button');
            btnRemove.type = 'button';
            btnRemove.className = 'btn btn-sm btn-block text-dark';
            btnRemove.style.backgroundColor = '#ffffff';
            btnRemove.style.border = 'var(--border-hairline)';
            btnRemove.style.fontSize = '11px';
            btnRemove.style.fontWeight = '600';
            btnRemove.innerHTML = '<i class="fa fa-trash mr-1"></i> Hapus';
            btnRemove.addEventListener('click', function () {
                dt.items.remove(index);
                input.files = dt.files;
                renderPreviews();
            });

            card.appendChild(img);
            card.appendChild(nameSmall);
            card.appendChild(btnRemove);
            col.appendChild(card);
            previewContainer.appendChild(col);
        });
    }
});
</script>
@endsection
