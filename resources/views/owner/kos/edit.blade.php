@extends('layouts.owner')

@section('title', 'Edit Kos: ' . $kos['title'] . ' - TEMPATIN')

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
                    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
                        <i class="fa fa-edit mr-1"></i> PERBARUI PROPERTI
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Edit {{ $kos['title'] }}
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Perbarui informasi kamar, status operasional, harga sewa, foto, dan fasilitas.
                    </p>
                </div>
                <div>
                    <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="btn btn-sm" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 8px 16px;">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali ke Detail
                    </a>
                </div>
            </div>

            <!-- FORM WRAPPER -->
            <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <form id="form-edit-kos" method="POST" action="{{ route('owner.kos.update', $kos['slug']) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- SECTION 1: INFORMASI DASAR -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">1</span>
                            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Informasi Properti</h2>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Nama Kos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $kos['title']) }}" placeholder="Nama Kos" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Tipe Kos <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror" name="type" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; height: 44px; padding: 0 14px;">
                                    <option value="">Pilih Tipe Kos...</option>
                                    <option value="Putra" {{ old('type', $kos['type']) === 'Putra' ? 'selected' : '' }}>Kos Putra</option>
                                    <option value="Putri" {{ old('type', $kos['type']) === 'Putri' ? 'selected' : '' }}>Kos Putri</option>
                                    <option value="Campur" {{ old('type', $kos['type']) === 'Campur' ? 'selected' : '' }}>Kos Campur</option>
                                    <option value="Eksklusif" {{ old('type', $kos['type']) === 'Eksklusif' ? 'selected' : '' }}>Kos Eksklusif</option>
                                </select>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Kota / Kabupaten <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', $kos['city']) }}" placeholder="Surabaya" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Harga Sewa / Bulan (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $kos['price']) }}" placeholder="850000" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Status Ketersediaan</label>
                                <select class="form-control" name="status" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; height: 44px; padding: 0 14px;">
                                    <option value="active" {{ old('status', $kos['status']) === 'active' ? 'selected' : '' }}>Aktif (Menerima Pesanan)</option>
                                    <option value="inactive" {{ old('status', $kos['status']) === 'inactive' ? 'selected' : '' }}>Nonaktif (Kamar Penuh / Renovasi)</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Alamat Lengkap</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $kos['address'] ?? '') }}" placeholder="Alamat kos" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: DESKRIPSI & THUMBNAIL -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">2</span>
                            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Deskripsi & Foto Sampul</h2>
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Deskripsi Kos</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 12px 14px; line-height: 1.5;">{{ old('description', $kos['description'] ?? '') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex align-items-center gap-3 p-3 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                            @if(!empty($kos['thumbnail']))
                                <img src="{{ asset($kos['thumbnail']) }}" alt="{{ $kos['title'] }}" class="rounded mr-3" style="width: 72px; height: 72px; object-fit: cover; border: var(--border-hairline);">
                            @endif
                            <div class="flex-grow-1">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 2px;">Ganti Foto Sampul Utama</label>
                                <input type="file" class="form-control-file @error('thumbnail') is-invalid @enderror" name="thumbnail" accept="image/*" style="font-size: 12.5px;">
                                <small class="text-muted d-block mt-1">Kosongkan jika ingin mempertahankan foto saat ini.</small>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: GALERI FOTO -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">3</span>
                            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Galeri Foto Properti</h2>
                        </div>

                        @if(isset($kos->photos) && $kos->photos->isNotEmpty())
                            <div class="mb-3">
                                <span style="font-size: 12px; font-weight: 700; color: var(--color-stone); text-transform: uppercase;">Foto Saat Ini:</span>
                                <span style="font-size: 12px; color: var(--color-stone); display: block;">Centang kotak di bawah foto untuk menghapus dari galeri.</span>
                            </div>
                            <div class="row mb-4">
                                @foreach($kos->photos as $photo)
                                    <div class="col-6 col-md-4 col-lg-3 mb-3">
                                        <div class="p-2 rounded text-center" style="background-color: var(--surface-page-canvas); border: var(--border-hairline);">
                                            <img src="{{ is_object($photo) ? $photo->url : (is_array($photo) ? ($photo['url'] ?? '') : $photo) }}" alt="Foto Kos" class="w-100 rounded mb-2" style="height: 110px; object-fit: cover;">
                                            <label class="d-flex align-items-center justify-content-center mb-0 cursor-pointer" style="font-size: 12px; color: var(--color-charcoal); font-weight: 600; cursor: pointer;">
                                                <input type="checkbox" name="delete_photos[]" value="{{ is_object($photo) ? $photo->id : (is_array($photo) ? ($photo['id'] ?? '') : $photo) }}" class="mr-1" style="accent-color: var(--color-notion-blue);">
                                                Hapus Foto
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label class="btn btn-sm d-inline-flex align-items-center mb-2" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 8px 16px; cursor: pointer;">
                                <i class="fa fa-images mr-2" style="color: var(--color-notion-blue);"></i> Tambah Foto Baru ke Galeri
                                <input type="file" class="d-none" id="photos-input" name="photos[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
                            </label>
                            <span id="photos-count-label" class="text-muted small ml-2">Belum ada foto baru dipilih.</span>
                        </div>

                        <div id="photos-preview-container" class="row"></div>
                    </div>

                    <!-- SECTION 4: FASILITAS -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">4</span>
                            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Fasilitas Kos</h2>
                        </div>

                        <div class="row">
                            @php
                                $selectedFacilities = old('facilities', isset($kos->facilities) ? $kos->facilities->pluck('id')->toArray() : []);
                            @endphp
                            @forelse($facilities as $facility)
                                <div class="col-6 col-md-4 col-lg-3 mb-2">
                                    <label for="facility-{{ $facility->id }}" class="p-2 rounded d-flex align-items-center mb-0 cursor-pointer" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13px; font-weight: 500; cursor: pointer;">
                                        <input type="checkbox" id="facility-{{ $facility->id }}" name="facilities[]" value="{{ $facility->id }}" class="mr-2" {{ in_array($facility->id, $selectedFacilities) ? 'checked' : '' }} style="accent-color: var(--color-notion-blue);">
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
                            <i class="fa fa-save mr-2"></i> Perbarui Data Kos
                        </button>
                        <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-weight: 600; font-size: 14px; padding: 12px 20px; border-radius: var(--radius-buttons);">
                            Batal
                        </a>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
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
            countLabel.textContent = 'Belum ada foto baru dipilih.';
            return;
        }

        countLabel.textContent = files.length + ' foto baru dipilih.';

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
            btnRemove.className = 'btn btn-sm btn-block text-danger';
            btnRemove.style.backgroundColor = '#ffffff';
            btnRemove.style.border = 'var(--border-hairline)';
            btnRemove.style.fontSize = '11px';
            btnRemove.style.fontWeight = '600';
            btnRemove.innerHTML = '<i class="fa fa-trash mr-1"></i> Batal';
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
