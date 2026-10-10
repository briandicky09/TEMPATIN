@extends('layouts.app')

@section('title', 'Daftar Akun Baru - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-auth-page" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="min-height: calc(100vh - 68px); display: flex; align-items: center; justify-content: center; padding-top: 25px; padding-bottom: 60px;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">

                    <!-- NOTION AUTH CARD -->
                    <div class="p-4 p-md-5 rounded shadow-sm" style="background-color: #ffffff; border: var(--border-hairline); border-radius: 16px;">

@php
    $selectedRole = old('role', request('role', 'customer'));
    $isOwner = in_array(strtolower($selectedRole), ['owner', 'pemilik']);
    $roleValue = $isOwner ? 'owner' : 'customer';
    $roleLabel = $isOwner ? 'Pemilik Kos' : 'Pencari Kos';
@endphp

                        <!-- Header Form: Back Button & Title Sesuai Referensi -->
                        <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                            <a href="{{ route('login', ['role' => $roleValue]) }}" class="mr-3 text-decoration-none d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 10px; border: var(--border-hairline); color: var(--color-midnight-ink, #02093a); background-color: var(--surface-page-canvas); transition: all 0.15s ease;" title="Kembali ke halaman masuk" onmouseover="this.style.backgroundColor='#e5e7eb'" onmouseout="this.style.backgroundColor='var(--surface-page-canvas)'">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="19" y1="12" x2="5" y2="12"></line>
                                    <polyline points="12 19 5 12 12 5"></polyline>
                                </svg>
                            </a>
                            <div class="flex-grow-1">
                                <h1 style="font-family: var(--font-serif); font-size: 1.45rem; font-weight: 700; color: var(--color-midnight-ink); margin: 0; line-height: 1.2;">
                                    Daftar Akun {{ $roleLabel }}
                                </h1>
                                <div class="mt-1" style="font-size: 12px;">
                                    @if($isOwner)
                                        <span style="color: var(--color-stone);">Bukan pemilik kos?</span>
                                        <a href="{{ route('register', ['role' => 'customer']) }}" style="color: var(--color-notion-blue, #0075de); font-weight: 600; text-decoration: none;">
                                            Daftar sebagai Pencari Kos
                                        </a>
                                    @else
                                        <span style="color: var(--color-stone);">Punya kos untuk disewakan?</span>
                                        <a href="{{ route('register', ['role' => 'owner']) }}" style="color: var(--color-notion-blue, #0075de); font-weight: 600; text-decoration: none;">
                                            Daftar sebagai Pemilik Kos
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <form id="form-register" class="ts-form" method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Hidden Role Input (Role ditentukan di awal alur modal) -->
                            <input type="hidden" name="role" id="reg-role" value="{{ $roleValue }}">
                            @error('role')
                                <span class="invalid-feedback d-block mb-3" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror

                            <!-- Nama Lengkap -->
                            <div class="form-group mb-3">
                                <label for="reg-nama" style="font-size: 13.5px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 5px;">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="reg-nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap sesuai identitas" required autofocus style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 13.5px; padding: 11px 14px;">
                                @error('nama')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Nomor Handphone -->
                            <div class="form-group mb-3">
                                <label for="reg-hp" style="font-size: 13.5px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 5px;">Nomor Handphone</label>
                                <input type="tel" class="form-control @error('handphone') is-invalid @enderror" id="reg-hp" name="handphone" value="{{ old('handphone') }}" placeholder="Isi dengan nomor handphone yang aktif" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 13.5px; padding: 11px 14px;">
                                @error('handphone')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group mb-3">
                                <label for="reg-email" style="font-size: 13.5px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 5px;">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="reg-email" name="email" value="{{ old('email') }}" placeholder="Masukkan email untuk akun TEMPATIN" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 13.5px; padding: 11px 14px;">
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label for="reg-password" style="font-size: 13.5px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 5px;">Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="reg-password" name="password" placeholder="Minimal 8 karakter" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 13.5px; padding: 11px 40px 11px 14px;">
                                    <button type="button" class="btn btn-link toggle-password-visibility" data-target="reg-password" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); color: #757575; text-decoration: none; padding: 4px; line-height: 1;" aria-label="Lihat kata sandi">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Ulangi Password -->
                            <div class="form-group mb-3">
                                <label for="reg-password-confirm" style="font-size: 13.5px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 5px;">Ulangi Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="reg-password-confirm" name="password_confirmation" placeholder="Masukkan kembali password" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 13.5px; padding: 11px 40px 11px 14px;">
                                    <button type="button" class="btn btn-link toggle-password-visibility" data-target="reg-password-confirm" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); color: #757575; text-decoration: none; padding: 4px; line-height: 1;" aria-label="Lihat kata sandi">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Terms & Privacy Checkbox Sesuai Referensi -->
                            <div class="form-group mb-4 mt-2">
                                <label class="d-flex align-items-start mb-0 cursor-pointer" style="font-size: 12.5px; color: var(--color-stone); cursor: pointer; line-height: 1.5;">
                                    <input type="checkbox" id="agree-terms" name="agree" {{ old('agree') ? 'checked' : '' }} required class="mr-2 mt-1" style="accent-color: var(--color-midnight-ink); min-width: 16px; min-height: 16px;">
                                    <span>Dengan klik Saya Setuju, saya menyatakan bahwa saya telah membaca dan menyetujui <a href="#" style="color: var(--color-notion-blue, #0075de); font-weight: 600; text-decoration: none;">Syarat dan Ketentuan</a> serta <a href="#" style="color: var(--color-notion-blue, #0075de); font-weight: 600; text-decoration: none;">Kebijakan Privasi</a> TEMPATIN.</span>
                                </label>
                                @error('agree')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Submit Button: Daftar -->
                            <button type="submit" class="btn btn-block" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 14.5px; padding: 12px; border-radius: var(--radius-buttons); border: none; transition: opacity 0.15s ease;">
                                Daftar
                            </button>

                            <!-- Login Link -->
                            <div class="text-center mt-4" style="font-size: 13px;">
                                <span style="color: var(--color-stone);">Sudah memiliki akun?</span>
                                <a href="{{ route('login', ['role' => $roleValue]) }}" style="color: var(--color-midnight-ink); font-weight: 600; text-decoration: none;" class="ml-1">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fitur Show/Hide Password Sesuai Icon Mata pada Referensi
    document.querySelectorAll('.toggle-password-visibility').forEach(function (button) {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (!targetInput) return;

            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});
</script>
@endpush
@endsection
