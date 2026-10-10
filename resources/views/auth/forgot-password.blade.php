@extends('layouts.app')

@section('title', 'Lupa Kata Sandi - TEMPATIN')

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
                                <i class="fa fa-key"></i>
                            </div>
                            <h1 style="font-family: var(--font-serif); font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                                Lupa Kata Sandi?
                            </h1>
                            <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 0;">
                                Masukkan alamat email terdaftar kamu. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
                            </p>
                        </div>

                        <form id="form-forgot-password" class="ts-form" method="POST" action="#" onsubmit="event.preventDefault(); alert('Instruksi pengaturan ulang kata sandi telah dikirim ke email kamu jika terdaftar di TEMPATIN.');">
                            @csrf

                            <!-- Email Input -->
                            <div class="form-group mb-4">
                                <label for="forgot-email" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Alamat Email</label>
                                <input type="email" class="form-control" id="forgot-email" name="email" placeholder="nama@email.com" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-block" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px; border-radius: var(--radius-buttons); border: none;">
                                Kirim Tautan Reset Sandi
                            </button>

                            <!-- Back to login link -->
                            <div class="text-center mt-4" style="font-size: 13px;">
                                <span style="color: var(--color-stone);">Sudah ingat kata sandi?</span>
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
