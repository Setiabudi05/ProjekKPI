@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="fw-bold">Dashboard Absensi</h3>
                <p class="text-subtitle text-muted">Pantau kehadiran anak magang secara real-time hari ini.</p>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-4 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="bi bi-people-fill d-flex align-items-center justify-content-center"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-8 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Magang</h6>
                                    <h6 class="font-extrabold mb-0">{{ $total_magang ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-4 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="bi bi-person-check-fill d-flex align-items-center justify-content-center"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-8 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Hadir</h6>
                                    <h6 class="font-extrabold mb-0">{{ $hadir_hari_ini ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-4 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="bi bi-person-clock-fill d-flex align-items-center justify-content-center"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-8 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Izin/Sakit</h6>
                                    <h6 class="font-extrabold mb-0">{{ $izin_sakit ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-4 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                        <i class="bi bi-person-x-fill d-flex align-items-center justify-content-center"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-8 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Alpha</h6>
                                    <h6 class="font-extrabold mb-0">{{ $alpha ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-2">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title">Riwayat Absensi Hari Ini</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle w-100" id="absensiTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Magang</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jam Masuk</th>
                                    <th class="text-center">Jam Pulang</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        $('#absensiTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.dashboard') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'text-center' },
                { data: 'nama_magang', name: 'intern.name', class: 'fw-bold' },
                { data: 'date', name: 'date', class: 'text-center' },
                { data: 'time_in', name: 'time_in', class: 'text-center' },
                { data: 'time_out', name: 'time_out', class: 'text-center' },
                { data: 'badge_status', name: 'status', orderable: false, class: 'text-center' },
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data absensi...",
            }
        });
    });
</script>
@endpush