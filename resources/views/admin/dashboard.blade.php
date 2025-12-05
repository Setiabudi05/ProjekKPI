@extends('admin.layouts.master')

@section('title', 'Dashboard Absensi')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Absensi</h1>
    </div>

    <!-- Row Card Statistik -->
    <div class="row mb-3">
        <!-- Total Anak Magang -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Anak Magang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_magang }}</div> 
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Hadir Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hadir_hari_ini }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Izin / Sakit -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Izin / Sakit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $izin_sakit }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alpha -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Alpha</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $alpha }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-times fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Tabel Absensi Riwayat -->
    <div class="col-xl-12 col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Absensi Hari Ini</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riwayat_absensi as $absen)
                            <tr>
                                <td>{{ $absen['no'] }}</td>
                                <td>{{ $absen['nama'] }}</td>
                                <td>{{ $absen['tanggal'] }}</td>
                                <td>{{ $absen['masuk'] }}</td>
                                <td>{{ $absen['pulang'] }}</td>
                                <td><span class="badge {{ $absen['badge_class'] }}">{{ $absen['status'] }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection