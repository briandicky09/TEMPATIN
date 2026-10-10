@extends('layouts.app')

@section('title', 'Daftar Akun Baru - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-auth-page" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="min-height: calc(100vh - 68px); display: flex; align-items: center; justify-content: center; padding-top: 30px; padding-bottom: 60px;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">

                    <!-- NOTION AUTH CARD -->
                    <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                        <!-- Card Header -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 8px; background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 1.25rem;">
                                <i class="fa fa-user-plus"></i>
                            </div>
                            <h1 style="font-family: var(--font-serif); font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                                Buat Akun TEMPATIN
                            </h1>
                            <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 0;">
                                Bergabunglah untuk mencari kos terverifikasi atau kelola hunian Anda dengan mudah.
                            </p>
                        </div>

                        <form id="form-register" class="ts-form" method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Nama Lengkap -->
                            <div class="form-group mb-3">
                                <label for="reg-nama" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 4px;">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="reg-nama" name="nama" value="{{ old('nama') }}" placeholder="cth. Brian Dicky" required autofocus style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('nama')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- No HP -->
                                <div class="col-md-6 form-group mb-3">
                                    <label for="reg-hp" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 4px;">Nomor WhatsApp</label>
                                    <input type="tel" class="form-control @error('handphone') is-invalid @enderror" id="reg-hp" name="handphone" value="{{ old('handphone') }}" placeholder="08xxxxxxxxxx" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                    @error('handphone')
                                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 form-group mb-3">
                                    <label for="reg-email" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 4px;">Alamat Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="reg-email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Role Selector -->
                            <div class="form-group mb-3">
                                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Tipe Akun</label>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="p-2 rounded d-flex align-items-center mb-0 cursor-pointer" style="border: var(--border-hairline); background-color: var(--surface-page-canvas); font-size: 13px; font-weight: 500; cursor: pointer;">
                                            <input type="radio" id="role-member" name="role" value="member" class="mr-2" {{ old('role', 'member') === 'member' ? 'checked' : '' }} required style="accent-color: var(--color-midnight-ink);">
                                            <span>Pencari Kos</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="p-2 rounded d-flex align-items-center mb-0 cursor-pointer" style="border: var(--border-hairline); background-color: var(--surface-page-canvas); font-size: 13px; font-weight: 500; cursor: pointer;">
                                            <input type="radio" id="role-owner" name="role" value="owner" class="mr-2" {{ old('role') === 'owner' ? 'checked' : '' }} required style="accent-color: var(--color-midnight-ink);">
                                            <span>Pemilik Kos</span>
                                        </label>
                                    </div>
                                </div>
                                @error('role')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-6 form-group mb-3">
                                    <label for="reg-password" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 4px;">Kata Sandi</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="reg-password" name="password" placeholder="Minimal 8 karakter" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Password Confirmation -->
                                <div class="col-md-6 form-group mb-3">
                                    <label for="reg-password-confirm" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 4px;">Ulangi Sandi</label>
                                    <input type="password" class="form-control" id="reg-password-confirm" name="password_confirmation" placeholder="Konfirmasi sandi" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                </div>
                            </div>

                            <!-- Terms Checkbox -->
                            <div class="form-group mb-4">
                                <label class="d-flex align-items-start mb-0 cursor-pointer" style="font-size: 12.5px; color: var(--color-stone); cursor: pointer;">
                                    <input type="checkbox" id="agree-terms" name="agree" {{ old('agree') ? 'checked' : '' }} required class="mr-2 mt-1" style="accent-color: var(--color-midnight-ink);">
                                    <span>Saya menyetujui <a href="#" style="color: var(--color-midnight-ink); font-weight: 600;">Syarat & Ketentuan</a> dan <a href="#" style="color: var(--color-midnight-ink); font-weight: 600;">Kebijakan Privasi</a> TEMPATIN.</span>
                                </label>
                                @error('agree')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-block" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px; border-radius: var(--radius-buttons); border: none;">
                                Daftar Akun Sekarang
                            </button>

                            <!-- Login Link -->
                            <div class="text-center mt-4" style="font-size: 13px;">
                                <span style="color: var(--color-stone);">Sudah memiliki akun?</span>
                                <a href="{{ route('login') }}" style="color: var(--color-midnight-ink); font-weight: 600; text-decoration: none;" class="ml-1">
                                    Masuk di sini
                                </a>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>

    </main>

    @include('partials.footer')

</div>
@endsection
