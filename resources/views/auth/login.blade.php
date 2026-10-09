@extends('layouts.app')

@section('title', 'Masuk - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-auth-page" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="min-height: calc(100vh - 120px); display: flex; align-items: center; justify-content: center; padding-top: 100px; padding-bottom: 60px;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">

                    <!-- NOTION AUTH CARD -->
                    <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                        <!-- Card Header -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 8px; background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 1.25rem;">
                                <i class="fa fa-user-lock"></i>
                            </div>
                            <h1 style="font-family: var(--font-serif); font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                                Masuk ke Akun Anda
                            </h1>
                            <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 0;">
                                Akses dashboard kos, riwayat invoice, dan kelola reservasi Anda.
                            </p>
                        </div>

                        <form id="form-login" class="ts-form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="form-group mb-3">
                                <label for="login-email" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="login-email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="form-group mb-3">
                                <label for="login-password" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Kata Sandi</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="login-password" name="password" placeholder="••••••••" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Remember + Forgot -->
                            <div class="d-flex justify-content-between align-items-center mb-4" style="font-size: 13px;">
                                <label class="d-flex align-items-center mb-0 cursor-pointer" style="cursor: pointer; color: var(--color-stone);">
                                    <input type="checkbox" id="remember-me" name="remember" {{ old('remember') ? 'checked' : '' }} class="mr-2" style="accent-color: var(--color-midnight-ink);">
                                    Ingat sesi saya
                                </label>
                                <a href="{{ route('password.request') }}" style="color: var(--color-midnight-ink); font-weight: 600; text-decoration: none;">
                                    Lupa sandi?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-block" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px; border-radius: var(--radius-buttons); border: none;">
                                Masuk Sekarang
                            </button>

                            <!-- Register Link -->
                            <div class="text-center mt-4" style="font-size: 13px;">
                                <span style="color: var(--color-stone);">Belum punya akun?</span>
                                <a href="{{ route('register') }}" style="color: var(--color-midnight-ink); font-weight: 600; text-decoration: none;" class="ml-1">
                                    Daftar di sini
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
