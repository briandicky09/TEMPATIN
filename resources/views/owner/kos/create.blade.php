@extends('layouts.owner')

@section('title', 'Tambah Kos - TEMPATIN')

@section('owner-content')
<main id="ts-main">
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="mb-1">Tambah Kos Baru</h2>
                    <p class="text-muted mb-0">Lengkapi data kos agar tampil konsisten dengan halaman owner lain.</p>
                </div>
                <a href="{{ route('owner.kos.my') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>

            <div class="card ts-card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <form id="form-create-kos" class="ts-form" method="POST" action="{{ route('owner.kos.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="border rounded p-3 p-md-4 mb-4">
                            <h6 class="font-weight-bold text-dark mb-3">Informasi Dasar</h6>

                            <div class="form-row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Nama Kos</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Contoh: Kos Putri Melati" required>
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Tipe Kos</label>
                                    <select class="custom-select" name="type" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="Putra" {{ old('type') === 'Putra' ? 'selected' : '' }}>Putra</option>
                                        <option value="Putri" {{ old('type') === 'Putri' ? 'selected' : '' }}>Putri</option>
                                        <option value="Campur" {{ old('type') === 'Campur' ? 'selected' : '' }}>Campur</option>
                                        <option value="Eksklusif" {{ old('type') === 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Kota</label>
                                    <input type="text" class="form-control" name="city" value="{{ old('city') }}" placeholder="Contoh: Surabaya" required>
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Harga / Bulan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="850000" required>
                                    </div>
                                </div>

                                <div class="col-12 form-group mb-0">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Alamat Lengkap</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Jl. Raya Sidoarjo No. 17">
                                </div>
                            </div>
                        </div>

                        <div class="border rounded p-3 p-md-4 mb-4">
                            <h6 class="font-weight-bold text-dark mb-3">Deskripsi & Foto Sampul</h6>

                            <div class="form-group mb-3">
                                <label class="ts-text-small font-weight-bold text-muted mb-1">Deskripsi</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Ceritakan keunggulan kos kamu...">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label class="ts-text-small font-weight-bold text-muted mb-1">Foto Sampul Utama (Thumbnail)</label>
                                <input type="file" class="form-control-file" name="thumbnail">
                                <small class="form-text text-muted">Foto utama yang akan tampil pada kartu pencarian dan daftar kos.</small>
                            </div>
                        </div>

                        <div class="border rounded p-3 p-md-4 mb-4">
                            <h6 class="font-weight-bold text-dark mb-1">Galeri Foto Kos</h6>
                            <p class="text-muted small mb-3">Anda dapat memilih beberapa foto sekaligus untuk ditampilkan pada galeri detail kos.</p>

                            <div class="form-group mb-3">
                                <label class="btn btn-outline-primary mb-2" style="cursor: pointer;">
                                    <i class="fa fa-folder-open mr-2"></i>Pilih Banyak Foto
                                    <input type="file" class="d-none" id="photos-input" name="photos[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
                                </label>
                                <span id="photos-count-label" class="text-muted small ml-2">Belum ada foto dipilih.</span>
                                <small class="form-text text-muted">Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB per file.</small>
                            </div>

                            @error('photos')
                                <div class="alert alert-danger py-2 mb-3">{{ $message }}</div>
                            @enderror
                            @error('photos.*')
                                <div class="alert alert-danger py-2 mb-3">{{ $message }}</div>
                            @enderror

                            <!-- Container Preview Foto Sebelum Submit -->
                            <div id="photos-preview-container" class="row"></div>
                        </div>

                        <div class="border rounded p-3 p-md-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="font-weight-bold text-dark mb-1">Fasilitas Kos</h6>
                                    <p class="text-muted small mb-0">Pilih fasilitas yang tersedia pada properti kos ini.</p>
                                </div>
                            </div>

                            @error('facilities')
                                <div class="alert alert-danger py-2 mb-3">{{ $message }}</div>
                            @enderror
                            @error('facilities.*')
                                <div class="alert alert-danger py-2 mb-3">{{ $message }}</div>
                            @enderror

                            <div class="row">
                                @forelse($facilities as $facility)
                                    <div class="col-6 col-md-4 col-lg-3 mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="facility-{{ $facility->id }}"
                                                   name="facilities[]"
                                                   value="{{ $facility->id }}"
                                                   {{ in_array($facility->id, old('facilities', [])) ? 'checked' : '' }}>
                                            <label class="custom-control-label font-weight-normal text-dark" for="facility-{{ $facility->id }}" style="cursor: pointer;">
                                                {{ $facility->name }}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted mb-0 small">Belum ada fasilitas yang terdaftar di sistem.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="d-flex flex-wrap">
                            <button type="submit" class="btn btn-primary font-weight-bold px-4 mr-2 mb-2">
                                <i class="fa fa-save mr-2"></i>Simpan Kos
                            </button>
                            <a href="{{ route('owner.kos.my') }}" class="btn btn-outline-dark font-weight-bold px-4 mb-2">Batal</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

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
            card.className = 'card h-100 border shadow-none overflow-hidden';

            const img = document.createElement('img');
            img.className = 'card-img-top';
            img.style.height = '130px';
            img.style.objectFit = 'cover';
            img.src = URL.createObjectURL(file);

            const cardBody = document.createElement('div');
            cardBody.className = 'card-body p-2 text-center bg-light';

            const nameSmall = document.createElement('small');
            nameSmall.className = 'd-block text-truncate text-muted mb-1';
            nameSmall.textContent = file.name;

            const btnRemove = document.createElement('button');
            btnRemove.type = 'button';
            btnRemove.className = 'btn btn-outline-danger btn-sm py-0 px-2';
            btnRemove.innerHTML = '<i class="fa fa-trash mr-1"></i>Hapus';
            btnRemove.addEventListener('click', function () {
                dt.items.remove(index);
                input.files = dt.files;
                renderPreviews();
            });

            cardBody.appendChild(nameSmall);
            cardBody.appendChild(btnRemove);

            card.appendChild(img);
            card.appendChild(cardBody);
            col.appendChild(card);
            previewContainer.appendChild(col);
        });
    }
});
</script>
@endsection
