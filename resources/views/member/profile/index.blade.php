@extends('layouts.app')

@section('title', 'Profil Saya - TEMPATIN')

@push('styles')
<style>
    .pk-profile-card {
        background: #fff;
        border: 0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    .pk-profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 30px;
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: #fff;
    }
    .pk-profile-avatar {
        width: 76px;
        height: 76px;
        padding: 10px;
        border-radius: 50%;
        background: #fff;
        object-fit: contain;
        flex-shrink: 0;
    }
    .pk-profile-header h2 {
        margin: 0 0 4px;
        font-size: 24px;
    }
    .pk-profile-header p {
        margin: 0;
        opacity: .85;
    }
    .pk-profile-body {
        padding: 30px;
    }
    .pk-profile-info {
        margin: 0;
    }
    .pk-profile-info-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 16px 0;
        border-bottom: 1px solid #e9ecef;
    }
    .pk-profile-info-row:first-child {
        padding-top: 0;
    }
    .pk-profile-info-row:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }
    .pk-profile-info-row dt {
        color: #6c757d;
        font-weight: 400;
        margin: 0;
    }
    .pk-profile-info-row dd {
        color: #333;
        font-weight: 600;
        margin: 0;
        text-align: right;
    }
    .pk-profile-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 25px;
    }
    @media (max-width: 576px) {
        .pk-profile-header,
        .pk-profile-body {
            padding: 20px;
        }
        .pk-profile-info-row {
            display: block;
        }
        .pk-profile-info-row dd {
            margin-top: 4px;
            text-align: left;
        }
    }
</style>
@endpush

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')

    @php
        $displayName = $user?->name ?? 'Member TEMPATIN';
        $displayEmail = $user?->email ?? 'Email belum tersedia';
        $displayRole = ucfirst($user?->role ?? 'member');
    @endphp

    <main id="ts-main">

        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('member.home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section id="page-title">
            <div class="container">
                <div class="ts-title mb-0">
                    <h1>Profil Saya</h1>
                    <h5 class="ts-opacity__90">
                        <i class="fa fa-user text-primary mr-2"></i>
                        Kelola dan lihat informasi akun kamu
                    </h5>
                </div>
            </div>
        </section>

        <section id="content" class="pb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="pk-profile-card">
                            <div class="pk-profile-header">
                                <img src="{{ asset('assets/svg/logo-profil.png') }}" alt="Profil {{ $displayName }}" class="pk-profile-avatar">
                                <div>
                                    <h2>{{ $displayName }}</h2>
                                    <p>{{ $displayEmail }}</p>
                                </div>
                            </div>
                            <div class="pk-profile-body">
                                <dl class="pk-profile-info">
                                    <div class="pk-profile-info-row">
                                        <dt>Nama lengkap</dt>
                                        <dd>{{ $displayName }}</dd>
                                    </div>
                                    <div class="pk-profile-info-row">
                                        <dt>Email</dt>
                                        <dd>{{ $displayEmail }}</dd>
                                    </div>
                                    <div class="pk-profile-info-row">
                                        <dt>Status akun</dt>
                                        <dd>{{ $displayRole }}</dd>
                                    </div>
                                </dl>

                                <div class="pk-profile-actions">
                                    <a href="{{ route('member.invoice.index') }}" class="btn btn-primary">
                                        <i class="fa fa-receipt mr-2"></i>Riwayat Transaksi
                                    </a>
                                    <a href="{{ route('member.contact') }}" class="btn btn-outline-dark">
                                        <i class="fa fa-life-ring mr-2"></i>Pusat Bantuan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
