@extends('layouts.app')

@section('title', 'Masuk - TEMPATIN')

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

@php
    $reqRole = request('role');
    $isOwner = in_array(strtolower($reqRole), ['owner', 'pemilik']);
    $isCustomer = in_array(strtolower($reqRole), ['customer', 'member', 'pencari']);
    $roleValue = $isOwner ? 'owner' : ($isCustomer ? 'customer' : null);
    $roleLabel = $isOwner ? 'Pemilik Kos' : ($isCustomer ? 'Pencari Kos' : null);
@endphp

                        <!-- Card Header -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 12px; background-color: {{ $isOwner ? 'var(--color-emerald-tint, #edf7ee)' : ($isCustomer ? 'var(--color-sky-tint, #e6f3fe)' : 'var(--surface-page-canvas)') }}; color: {{ $isOwner ? '#059669' : ($isCustomer ? 'var(--color-signal-blue, #097fe8)' : 'var(--color-midnight-ink)') }}; border: var(--border-hairline); font-size: 1.3rem;">
                                <i class="fa {{ $isOwner ? 'fa-home' : ($isCustomer ? 'fa-user' : 'fa-user-lock') }}"></i>
                            </div>
                            @if($roleLabel)
                                <div class="mb-2">
                                    <span class="d-inline-flex align-items-center px-2 py-1 rounded" style="background-color: {{ $isOwner ? 'var(--color-emerald-tint, #edf7ee)' : 'var(--color-sky-tint, #e6f3fe)' }}; color: {{ $isOwner ? '#059669' : 'var(--color-signal-blue, #097fe8)' }}; font-size: 12px; font-weight: 600; border: 1px solid {{ $isOwner ? 'rgba(5,150,105,0.2)' : 'rgba(9,127,232,0.2)' }};">
                                        <i class="fa {{ $isOwner ? 'fa-building mr-1' : 'fa-user mr-1' }}"></i> {{ $roleLabel }}
                                    </span>
                                </div>
                                <h1 style="font-family: var(--font-serif); font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                                    Masuk sebagai {{ $roleLabel }}
                                </h1>
                                <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 0;">
                                    {{ $isOwner ? 'Kelola kamar, pantau penyewa, dan akses dashboard properti Anda.' : 'Akses riwayat sewa, kos favorit, dan kelola reservasi hunian Anda.' }}
                                </p>
                                <div class="mt-2" style="font-size: 12.5px;">
                                    @if($isOwner)
                                        <span style="color: var(--color-stone);">Bukan pemilik kos?</span>
                                        <a href="{{ route('login', ['role' => 'customer']) }}" style="color: var(--color-notion-blue, #0075de); font-weight: 600; text-decoration: none;">
                                            Masuk sebagai Pencari Kos
                                        </a>
                                    @else
                                        <span style="color: var(--color-stone);">Anda pemilik kos?</span>
                                        <a href="{{ route('login', ['role' => 'owner']) }}" style="color: var(--color-notion-blue, #0075de); font-weight: 600; text-decoration: none;">
                                            Masuk sebagai Pemilik Kos
                                        </a>
                                    @endif
                                </div>
                            @else
                                <h1 style="font-family: var(--font-serif); font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                                    Masuk ke Akun Anda
                                </h1>
                                <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 0;">
                                    Akses dashboard kos, riwayat invoice, dan kelola reservasi Anda.
                                </p>
                            @endif
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

                            <!-- Divider -->
                            <div class="d-flex align-items-center my-3">
                                <hr class="flex-grow-1 my-0" style="border-top: var(--border-hairline);">
                                <span class="px-3" style="font-size: 12px; color: var(--color-stone); font-weight: 500;">atau</span>
                                <hr class="flex-grow-1 my-0" style="border-top: var(--border-hairline);">
                            </div>

                            <!-- Google Login Button -->
                            <a href="{{ route('auth.google', ['action' => 'login', 'role' => $roleValue ?: 'customer']) }}" class="btn btn-block d-flex align-items-center justify-content-center" style="background-color: #ffffff; color: var(--color-midnight-ink); font-weight: 600; font-size: 14px; padding: 11px; border-radius: var(--radius-buttons); border: var(--border-hairline); box-shadow: 0 1px 2px rgba(0,0,0,0.05); text-decoration: none; transition: background-color 0.15s ease;">
                                <svg class="mr-2" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                </svg>
                                <span>Masuk dengan Google</span>
                            </a>

                            <!-- Register Link -->
                            <div class="text-center mt-4" style="font-size: 13px;">
                                <span style="color: var(--color-stone);">Belum punya akun?</span>
                                <a href="{{ route('register', $roleValue ? ['role' => $roleValue] : []) }}" style="color: var(--color-midnight-ink); font-weight: 600; text-decoration: none;" class="ml-1">
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
