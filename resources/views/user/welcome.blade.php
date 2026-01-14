@extends('layouts.user')

@section('title', 'Dashboard | Absensi Magang')

@section('content')

<h2 class="mb-4 text-dark fs-2 fw-bold">
    👋 Selamat Datang, {{ Auth::user()->name }}!
</h2>
<p class="text-secondary mb-5">
    Ini adalah pusat informasi dan absensi harian Anda.
</p>

{{-- ROW CARD ATAS --}}
<div class="row g-4 mb-5">

    {{-- AKSI ABSENSI --}}
    <div class="col-lg-6 col-md-12">
        <div class="card text-center h-100 p-4 border-primary border-3 shadow-sm">
            <h4 class="mb-4 text-primary fw-bolder">
                Aksi Absensi Hari Ini
            </h4>

            @php
                $status_absen = 'Belum Absen';
                $tombol_text = 'Absen Masuk';
            @endphp

            <button class="btn btn-primary btn-lg w-75 mb-3 fw-bold shadow">
                {{ $tombol_text }}
            </button>

            <p class="text-secondary small">
                Status saat ini: <strong>{{ $status_absen }}</strong>
            </p>
        </div>
    </div>

    {{-- HADIR BULAN INI --}}
    <div class="col-lg-3 col-md-6">
        <div class="card bg-success text-white p-4 h-100 shadow">
            <i class="fas fa-calendar-check fa-2x mb-3 opacity-75"></i>
            <h5 class="opacity-75">Hadir Bulan Ini</h5>
            <p class="fs-3 fw-bold mb-0">18 / 22 Hari</p>
        </div>
    </div>

    {{-- STATUS HARIAN --}}
    <div class="col-lg-3 col-md-6">
        <div class="card bg-warning text-dark p-4 h-100 shadow">
            <i class="fas fa-exclamation-triangle fa-2x mb-3 opacity-75"></i>
            <h5 class="opacity-75">Status Harian</h5>
            <p class="fs-3 fw-bold mb-0">Belum Absen</p>
        </div>
    </div>

</div>

{{-- RIWAYAT ABSENSI --}}
<div class="card p-4 shadow-sm">
    <h4 class="mb-4 text-dark">
        <i class="fas fa-history me-2"></i> Riwayat Absensi
    </h4>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Total Jam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2023-12-04</td>
                    <td>08:00</td>
                    <td>17:00</td>
                    <td>9 Jam</td>
                    <td>
                        <span class="badge bg-success">Hadir</span>
                    </td>
                </tr>
                <tr>
                    <td>2023-12-03</td>
                    <td>08:05</td>
                    <td>17:00</td>
                    <td>8 Jam 55 Min</td>
                    <td>
                        <span class="badge bg-warning text-dark">Terlambat</span>
                    </td>
                </tr>
                <tr>
                    <td>2023-12-02</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <span class="badge bg-info">Izin</span>
                    </td>
                </tr>
                <tr>
                    <td>2023-12-01</td>
                    <td>07:58</td>
                    <td>17:01</td>
                    <td>9 Jam 3 Min</td>
                    <td>
                        <span class="badge bg-success">Hadir</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection