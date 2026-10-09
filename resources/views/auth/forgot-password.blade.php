@extends('layouts.app')

@section('title', 'Lupa Kata Sandi - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-auth-page" id="page-top">

    <!--*********************************************************************************************************-->
    <!--HEADER **************************************************************************************************-->
    <!--*********************************************************************************************************-->
    @include('partials.navbar')

    @include('partials.alert')
    <!--end Header-->

    <!--*********************************************************************************************************-->
    <!-- MAIN CONTENT (Forgot Password Page) ***********************************************************************-->
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
                                <h4 class="mb-1 font-weight-bold">Lupa Kata Sandi</h4>
                                <p class="text-muted ts-text-small mb-0">Masukkan email kamu, kami akan kirimkan tautan untuk atur ulang kata sandi.</p>
                            </div>

                            {{-- TODO: arahkan action ke route POST forgot-password setelah autentikasi diimplementasikan --}}
                            <form id="form-forgot-password" class="ts-form" method="POST" action="#">
                                @csrf

                                <!--Email-->
                                <div class="form-group mb-4">
                                    <input type="email" class="form-control" id="forgot-email" name="email" placeholder="Email (nama@email.com)" required>
                                </div>

                                <!-- TOMBOL KIRIM (Warna Biru Muda) -->
                                <button type="submit" class="btn text-white w-100 mb-3 font-weight-bold" style="background-color: #38b6ff; border-color: #38b6ff;">
                                    KIRIM TAUTAN RESET
                                </button>

                                <!-- Link Kembali -->
                                <div class="text-center mt-4 ts-text-small">
                                    <p class="mb-0 text-muted">
                                        Sudah ingat kata sandi? <a href="{{ route('login') }}" class="font-weight-bold" style="color: #007bff; text-decoration: underline;">Masuk di sini</a>
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
