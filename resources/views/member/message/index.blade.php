@extends('layouts.app')

@section('title', 'Pesan - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">
    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main">
        <section class="py-5" style="min-height: calc(100vh - 150px);">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm" style="border-radius: 18px;">
                            <div class="card-body p-5 text-center">
                                <div class="mb-4" style="font-size: 64px; color: #d9dee8;">
                                    <i class="fa fa-comment-dots"></i>
                                </div>
                                <h2 class="mb-3">Belum ada pesan</h2>
                                <p class="text-muted mb-4" style="font-size: 1.05rem;">
                                    Saat ini belum ada percakapan aktif. Hubungi admin atau pemilik kos untuk memulai chat.
                                </p>
                                <a href="{{ route('member.home') }}" class="btn btn-primary px-4">Kembali ke Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection
