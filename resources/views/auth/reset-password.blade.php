@extends('layouts.app')

@section('title', 'Atur Ulang Kata Sandi - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-auth-page" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="min-height: calc(100vh - 68px); display: flex; align-items: center; justify-content: center; padding-top: 30px; padding-bottom: 60px;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">

                    <!-- NOTION AUTH CARD -->
                    <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                        <!-- Card Header -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 8px; background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 1.25rem;">
                                <i class="fa fa-lock"></i>
                            </div>
                            <h1 style="font-family: var(--font-serif); font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                                Buat Kata Sandi Baru
                            </h1>
                            <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 0;">
                                Masukkan kata sandi baru untuk akun TEMPATIN kamu.
                            </p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4" role="alert" style="border-radius: var(--radius-buttons); font-size: 13.5px; border-left: 4px solid #ef4444;">
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="form-reset-password" class="ts-form" method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <!-- Email Input -->
                            <div class="form-group mb-3">
                                <label for="reset-email" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Alamat Email</label>
                                <input type="email" class="form-control" id="reset-email" name="email" value="{{ old('email', $email) }}" required readonly style="background-color: var(--surface-page-canvas); border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                            </div>

                            <!-- New Password Input -->
                            <div class="form-group mb-3">
                                <label for="reset-password" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Kata Sandi Baru</label>
                                <input type="password" class="form-control" id="reset-password" name="password" placeholder="Minimal 8 karakter" required autofocus style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                            </div>

                            <!-- Confirm Password Input -->
                            <div class="form-group mb-4">
                                <label for="reset-password-confirm" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Ulangi Kata Sandi Baru</label>
                                <input type="password" class="form-control" id="reset-password-confirm" name="password_confirmation" placeholder="Ulangi kata sandi baru" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-block" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px; border-radius: var(--radius-buttons); border: none;">
                                Simpan Kata Sandi Baru
                            </button>

                            <!-- Back to login link -->
                            <div class="text-center mt-4" style="font-size: 13px;">
                                <a href="{{ route('login') }}" style="color: var(--color-stone); text-decoration: none;">
                                    <i class="fa fa-arrow-left mr-1"></i> Kembali ke Halaman Masuk
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
