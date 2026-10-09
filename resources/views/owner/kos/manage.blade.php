@extends('layouts.owner')

@section('title', 'Manajemen Kos - TEMPATIN')

@section('owner-content')
<main id="ts-main">
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="mb-1">Manajemen Kos</h2>
                    <p class="text-muted mb-0">Pantau dan kelola semua kos yang Anda miliki.</p>
                </div>
                <a href="{{ route('owner.kos.create') }}" class="btn btn-primary">+ Tambah Kos</a>
            </div>

            <div class="card ts-card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama Kos</th>
                                    <th>Kota</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listKos as $kos)
                                    <tr>
                                        <td>
                                            <strong>{{ $kos['title'] }}</strong><br>
                                            <small class="text-muted">{{ ucfirst($kos['type']) }}</small>
                                        </td>
                                        <td>{{ $kos['city'] }}</td>
                                        <td>Rp {{ number_format($kos['price'], 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge {{ ($kos['status'] === 'Aktif' || $kos['status'] === 'active') ? 'badge-success' : 'badge-secondary' }}">{{ $kos['status'] === 'active' ? 'Aktif' : ($kos['status'] === 'inactive' ? 'Nonaktif' : $kos['status']) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
