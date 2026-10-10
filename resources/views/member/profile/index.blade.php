@extends('layouts.app')

@section('title', 'Profil Saya - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    @php
        $displayName = $user?->name ?? 'Member TEMPATIN';
        $displayEmail = $user?->email ?? 'Email belum tersedia';
        $displayPhone = $user?->phone ?? 'Belum diisi';
        $displayRole = ucfirst($user?->role ?? 'member');
    @endphp

    <main id="ts-main" style="padding-top: 6px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Profil Saya</li>
                </ol>
            </nav>
        </div>

        <section class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">

                    <!-- NOTION PROFILE CARD -->
                    <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                        <!-- Avatar & Identity -->
                        <div class="d-flex align-items-center pb-4 mb-4 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $displayName }}" class="rounded-circle mr-3" style="width: 68px; height: 68px; object-fit: cover; border: var(--border-hairline); box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            @else
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 68px; height: 68px; background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 26px; font-weight: 700;">
                                    {{ strtoupper(substr($displayName, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h1 style="font-family: var(--font-serif); font-size: 1.5rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">
                                    {{ $displayName }}
                                </h1>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                        {{ $displayRole }}
                                    </span>
                                    <span style="font-size: 13px; color: var(--color-stone);">{{ $displayEmail }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info List -->
                        <div class="mb-4">
                            <h2 style="font-size: 12px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em; margin-bottom: 12px;">
                                INFORMASI AKUN
                            </h2>
                            <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important; font-size: 13.5px;">
                                <span style="color: var(--color-stone);">Nama Lengkap</span>
                                <strong style="color: var(--color-midnight-ink);">{{ $displayName }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important; font-size: 13.5px;">
                                <span style="color: var(--color-stone);">Email Terdaftar</span>
                                <strong style="color: var(--color-midnight-ink);">{{ $displayEmail }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important; font-size: 13.5px;">
                                <span style="color: var(--color-stone);">Nomor Telepon</span>
                                <strong style="color: var(--color-midnight-ink);">{{ $displayPhone }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-2" style="font-size: 13.5px;">
                                <span style="color: var(--color-stone);">Status Keanggotaan</span>
                                <span style="color: var(--color-midnight-ink); font-weight: 600;"><i class="fa fa-check-circle mr-1" style="color: var(--color-charcoal);"></i> Aktif Terverifikasi</span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="pt-3 border-top d-flex flex-wrap gap-2 justify-content-between align-items-center" style="border-color: rgba(0,0,0,0.06) !important;">
                            <div>
                                <button type="button" class="btn" data-toggle="modal" data-target="#editProfileModal" id="btnEditProfile" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 10px 18px; border: none; box-shadow: 0 2px 8px rgba(0, 117, 222, 0.25);">
                                    <i class="fa fa-user-edit mr-2"></i> Edit Profil
                                </button>
                                <a href="{{ route('member.invoice.index') }}" class="btn ml-2" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 10px 18px; border: none;">
                                    <i class="fa fa-file-invoice mr-2"></i> Riwayat Invoice
                                </a>
                            </div>
                            <a href="{{ route('member.contact') }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 10px 18px;">
                                <i class="fa fa-life-ring mr-2"></i> Pusat Bantuan
                            </a>
                        </div>

                    </div>

                    <!-- MODAL EDIT PROFIL -->
                    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="border-radius: var(--radius-cards); border: var(--border-hairline); overflow: hidden;">
                                <div class="modal-header border-bottom py-3 px-4" style="background-color: var(--surface-page-canvas);">
                                    <h5 class="modal-title font-weight-bold" id="editProfileModalLabel" style="font-family: var(--font-serif); font-size: 1.2rem; color: var(--color-midnight-ink);">
                                        <i class="fa fa-user-edit mr-2 text-primary"></i> Edit Profil Member
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body p-4">
                                        <!-- Upload Foto Profil -->
                                        <div class="form-group mb-4 text-center">
                                            <label class="d-block font-weight-600 text-dark small mb-2 text-left">Foto Profil</label>
                                            <div class="d-inline-block position-relative">
                                                @if($user->avatar)
                                                    <img id="avatarPreviewImg" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $displayName }}" class="rounded-circle shadow-sm" style="width: 86px; height: 86px; object-fit: cover; border: 2px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;">
                                                    <div id="avatarFallbackBox" class="rounded-circle d-none align-items-center justify-content-center shadow-sm" style="width: 86px; height: 86px; background-color: #f1f5f9; color: var(--color-midnight-ink); font-size: 30px; font-weight: 700; border: 2px solid #ffffff;">
                                                        {{ strtoupper(substr($displayName, 0, 1)) }}
                                                    </div>
                                                @else
                                                    <img id="avatarPreviewImg" src="" alt="Preview" class="rounded-circle shadow-sm d-none" style="width: 86px; height: 86px; object-fit: cover; border: 2px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;">
                                                    <div id="avatarFallbackBox" class="rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 86px; height: 86px; background-color: #f1f5f9; color: var(--color-midnight-ink); font-size: 30px; font-weight: 700; border: 2px solid #ffffff;">
                                                        {{ strtoupper(substr($displayName, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <label for="inputAvatar" class="position-absolute d-inline-flex align-items-center justify-content-center" style="bottom: 0; right: 0; width: 30px; height: 30px; border-radius: 50%; background-color: var(--color-notion-blue); color: #ffffff; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.25); margin: 0;" title="Pilih Foto Profil">
                                                    <i class="fa fa-camera" style="font-size: 13px;"></i>
                                                </label>
                                            </div>
                                            <input type="file" class="d-none" id="inputAvatar" name="avatar" accept="image/jpeg,image/png,image/jpg,image/webp">
                                            <div class="small text-muted mt-2" style="font-size: 11.5px;">Klik ikon kamera untuk memilih foto profil (Maks 2MB)</div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="inputName" class="font-weight-600 text-dark small mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputName" name="name" value="{{ old('name', $user->name) }}" required style="border-radius: 8px; font-size: 14px;">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="inputEmail" class="font-weight-600 text-dark small mb-1">Email Terdaftar</label>
                                            <input type="email" class="form-control bg-light" id="inputEmail" value="{{ $user->email }}" disabled readonly style="border-radius: 8px; font-size: 14px; cursor: not-allowed;">
                                            <small class="text-muted" style="font-size: 11px;">Email akun tidak dapat diubah.</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="inputPhone" class="font-weight-600 text-dark small mb-1">Nomor Telepon / WhatsApp</label>
                                            <input type="tel" class="form-control" id="inputPhone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" style="border-radius: 8px; font-size: 14px;">
                                        </div>
                                        <hr class="my-3">
                                        <div class="form-group mb-3">
                                            <label for="inputPassword" class="font-weight-600 text-dark small mb-1">Kata Sandi Baru <span class="text-muted">(Kosongkan jika tidak diubah)</span></label>
                                            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Minimal 6 karakter" style="border-radius: 8px; font-size: 14px;">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="inputPasswordConfirm" class="font-weight-600 text-dark small mb-1">Konfirmasi Kata Sandi Baru</label>
                                            <input type="password" class="form-control" id="inputPasswordConfirm" name="password_confirmation" placeholder="Ulangi kata sandi baru" style="border-radius: 8px; font-size: 14px;">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top px-4 py-3 bg-light d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px; font-weight: 500;">Batal</button>
                                        <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--color-notion-blue); border: none; border-radius: 6px; font-weight: 600; padding: 7px 18px;">
                                            <i class="fa fa-save mr-1"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#inputAvatar').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            $('#avatarPreviewImg').attr('src', url).removeClass('d-none');
            $('#avatarFallbackBox').addClass('d-none');
        }
    });

    if (window.location.hash === '#edit' || window.location.search.indexOf('edit=1') !== -1 || {{ $errors->any() ? 'true' : 'false' }}) {
        $('#editProfileModal').modal('show');
    }
});
</script>
@endpush
@endsection
