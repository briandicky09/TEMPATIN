@extends('layouts.app')

@section('title', 'Daftar - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-auth-page" id="page-top">

    <!--*********************************************************************************************************-->
    <!--HEADER **************************************************************************************************-->
    <!--*********************************************************************************************************-->
    @include('partials.navbar')

    @include('partials.alert')
    <!--end Header-->

    <!--*********************************************************************************************************-->
    <!-- MAIN CONTENT (Register Page) ****************************************************************************-->
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
                                <h4 class="mb-1 font-weight-bold">Daftar Akun Baru</h4>
                            </div>

                            <form id="form-register" class="ts-form" method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row">
                                    <!--Nama Lengkap-->
                                    <div class="col-md-12 form-group mb-3">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="reg-nama" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap" required autofocus>
                                        @error('nama')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!--No HP-->
                                    <div class="col-md-12 form-group mb-3">
                                        <input type="tel" class="form-control @error('handphone') is-invalid @enderror" id="reg-hp" name="handphone" value="{{ old('handphone') }}" placeholder="No. Handphone (08xxxxxxxx)" required>
                                        @error('handphone')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!--Email-->
                                    <div class="col-md-12 form-group mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="reg-email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                                        @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!--Role Akun-->
                                    <div class="col-md-12 form-group mb-3">
                                        <label class="d-block text-muted mb-2" style="font-size: 13px;">Daftar sebagai</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="role-owner" name="role" value="owner" class="custom-control-input" {{ old('role') === 'owner' ? 'checked' : '' }} required>
                                            <label class="custom-control-label" for="role-owner">Owner (Pemilik Kos)</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="role-member" name="role" value="member" class="custom-control-input" {{ old('role', 'member') === 'member' ? 'checked' : '' }} required>
                                            <label class="custom-control-label" for="role-member">Member (Pencari Kos)</label>
                                        </div>
                                        @error('role')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!--Password-->
                                    <div class="col-md-6 form-group mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="reg-password" name="password" placeholder="Kata Sandi" required>
                                        @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!--Konfirmasi Password-->
                                    <div class="col-md-6 form-group mb-3">
                                        <input type="password" class="form-control" id="reg-password-confirm" name="password_confirmation" placeholder="Ulangi Sandi" required>
                                    </div>
                                </div>
                                <!--end row-->

                                <!-- Checkbox S&K -->
                                <div class="custom-control custom-checkbox mb-4 mt-2">
                                    <input type="checkbox" class="custom-control-input @error('agree') is-invalid @enderror" id="agree-terms" name="agree" {{ old('agree') ? 'checked' : '' }} required>
                                    <label class="custom-control-label text-muted" for="agree-terms" style="font-size: 13px;">
                                        Saya menyetujui <a href="#" class="text-dark font-weight-bold">Syarat &amp; Ketentuan</a> dan <a href="#" class="text-dark font-weight-bold">Kebijakan Privasi</a>
                                    </label>
                                    @error('agree')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- TOMBOL DAFTAR -->
                                <button type="submit" class="btn btn-primary w-100 mb-3 font-weight-bold py-2">
                                    DAFTAR
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

                                <!-- Link Masuk -->
                                <div class="text-center mt-4 ts-text-small">
                                    <p class="mb-0 text-muted">
                                        Sudah punya akun? <a href="{{ route('login') }}" class="font-weight-bold text-primary">Masuk di sini</a>
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
