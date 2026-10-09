@extends('layouts.app')

@section('title', 'Masuk - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-auth-page" id="page-top">

    <!--*********************************************************************************************************-->
    <!-- TOP NAVBAR (Fixed Top agar PASTI selalu muncul saat di-scroll) *****************************************-->
    <!--*********************************************************************************************************-->
    <!--*********************************************************************************************************-->
    <!--HEADER **************************************************************************************************-->
    <!--*********************************************************************************************************-->
    @include('partials.navbar')

    @include('partials.alert')
    <!--end Header-->

    <!--*********************************************************************************************************-->
    <!-- MAIN CONTENT (Login Page) ****************************************************************************-->
    <!--*********************************************************************************************************-->
    
    <main id="ts-main" style="background-image: url('{{ asset('assets/img/gambar-koss.jpeg') }}'); background-size: cover; background-position: center center; background-repeat: no-repeat; min-height: calc(100vh + 160px); margin-top: 0 !important; padding: 0 !important; background-color: transparent;">

        <section id="ts-auth" class="py-5" style="position: relative; min-height: calc(100vh + 160px); display: flex; align-items: center; justify-content: center; margin-bottom: 0 !important; background: transparent;">
            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.28); z-index: 1;"></div>
            <div class="container py-5" style="position: relative; z-index: 2;">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5">
                        <div class="card ts-card p-4 p-md-5 border-0 shadow-lg" style="border-radius: 8px; background: rgba(255,255,255,0.96); backdrop-filter: blur(10px);">

                            <!-- Judul Card -->
                            <div class="mb-4">
                                <h4 class="mb-1 font-weight-bold">Masuk ke Akun Kamu</h4>
                            </div>

                            <form id="form-login" class="ts-form" method="POST" action="{{ route('login') }}">
                                @csrf

                                <!--Email-->
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="login-email" name="email" value="{{ old('email') }}" placeholder="Email (nama@email.com)" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!--Password-->
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="login-password" name="password" placeholder="Kata Sandi" required>
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!--Remember + Forgot-->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remember-me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label ts-text-small text-muted" for="remember-me">Ingat saya</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="ts-text-small font-weight-bold" style="color: #007bff;">Lupa kata sandi?</a>
                                </div>

                                <!-- TOMBOL MASUK (Warna Biru Muda) -->
                                <button type="submit" class="btn text-white w-100 mb-3 font-weight-bold" style="background-color: #38b6ff; border-color: #38b6ff;">
                                    MASUK
                                </button>

                                <!-- Divider -->
                                <div class="d-flex align-items-center mb-3">
                                    <hr class="flex-grow-1">
                                    <span class="mx-2 text-muted ts-text-small">ATAU</span>
                                    <hr class="flex-grow-1">
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <a href="#" class="btn btn-outline-dark w-100">
                                            <i class="fab fa-facebook-f mr-1"></i> Facebook
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="#" class="btn btn-outline-dark w-100">
                                            <i class="fab fa-google mr-1"></i> Google
                                        </a>
                                    </div>
                                </div>

                                <!-- Link Daftar (Biru Link) -->
                                <div class="text-center mt-4 ts-text-small">
                                    <p class="mb-0 text-muted">
                                        Belum punya akun? <a href="{{ route('register') }}" class="font-weight-bold" style="color: #007bff; text-decoration: underline;">Daftar di sini</a>
                                    </p>
                                </div>

                            </form>

                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>
        <!--end ts-auth-->

    </main>
    <!--end #ts-main-->

    <!--*********************************************************************************************************-->
    <!--************ FOOTER *************************************************************************************-->
    <!--*********************************************************************************************************-->
    
    @include('partials.footer')

</div>
<!--end .ts-page-wrapper-->
@endsection
