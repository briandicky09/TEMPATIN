@extends('layouts.owner')

@section('title', 'Tambah Kos Baru - TEMPATIN')

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
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">1</span>
                            <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Informasi Properti</h2>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Nama Kos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="cth. Kos Putri Melati Kampus C" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Tipe Kos <span class="text-danger">*</span></label>
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
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Kota / Kabupaten <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" placeholder="cth. Surabaya" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Harga Sewa / Bulan (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" placeholder="850000" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 form-group mb-0">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Alamat Lengkap</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" placeholder="cth. Jl. Mulyorejo No. 45, RT 02 / RW 05" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: DESKRIPSI & THUMBNAIL -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">2</span>
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

                    <!-- SECTION 3: GALERI FOTO BANYAK -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">3</span>
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

                    <!-- SECTION 4: FASILITAS -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span class="mr-2" style="width: 24px; height: 24px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">4</span>
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
            btnRemove.className = 'btn btn-sm btn-block text-danger';
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
