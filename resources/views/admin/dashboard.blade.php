@extends('layouts.master')

@section('title', 'Dashboard - Manajemen Magang')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <style>
        .card-stats-primary { border-left: 4px solid #435ebe; }
        .card-stats-success { border-left: 4px solid #198754; }
        .card-stats-info { border-left: 4px solid #0dcaf0; }
        .card-stats-danger { border-left: 4px solid #dc3545; }
        .stats-icon i { font-size: 1.4rem; color: #fff; display: flex; align-items: center; justify-content: center; }
        .card { border: none; transition: transform 0.2s; border-radius: 12px; }
        .badge-ai { background: linear-gradient(45deg, #435ebe, #55c6e8); color: white; font-size: 0.65rem; padding: 0.2rem 0.5rem; border-radius: 50px; }
        .avatar-sm { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
        .badge-status { font-size: 0.7rem; text-transform: uppercase; font-weight: bold; }
    </style>
@endpush

@section('content')
    <div class="page-heading">
        <h3 class="fw-bold"><i class="bi bi-person-workspace me-2 text-primary"></i>Dashboard Magang <span class="badge-ai ms-2">Live Status</span></h3>
        <p class="text-muted small">Ringkasan aktivitas peserta magang.</p>
    </div>

    <div class="page-content mt-3">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card card-stats-primary shadow-sm h-100">
                            <div class="card-body px-3 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon purple me-3" style="background-color: #9694ff;"><i class="bi bi-people-fill"></i></div>
                                    <div>
                                        <h6 class="text-muted font-semibold small text-uppercase">Total Intern</h6>
                                        <h4 class="font-extrabold mb-0">{{ $totalInterns }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card card-stats-info shadow-sm h-100">
                            <div class="card-body px-3 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon blue me-3" style="background-color: #57caeb;"><i class="bi bi-person-check-fill"></i></div>
                                    <div>
                                        <h6 class="text-muted font-semibold small text-uppercase">Aktif</h6>
                                        <h4 class="font-extrabold mb-0">{{ $internsActive }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card card-stats-success shadow-sm h-100">
                            <div class="card-body px-3 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon green me-3" style="background-color: #5ddab4;"><i class="bi bi-calendar2-check-fill"></i></div>
                                    <div>
                                        <h6 class="text-muted font-semibold small text-uppercase">Hadir</h6>
                                        <h4 class="font-extrabold mb-0">{{ $attendanceToday }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card card-stats-danger shadow-sm h-100">
                            <div class="card-body px-3 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon red me-3" style="background-color: #ff7976;"><i class="bi bi-shield-lock-fill"></i></div>
                                    <div>
                                        <h6 class="text-muted font-semibold small text-uppercase">Admin</h6>
                                        <h4 class="font-extrabold mb-0">{{ $totalAdmin }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-2 shadow-sm border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center border-0">
                        <h4 class="card-title mb-0 fw-bold">Monitor Absensi Hari Ini</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="tableAttendance" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Peserta</th>
                                        <th class="text-center">Masuk</th>
                                        <th class="text-center">Keluar</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="card shadow-sm text-center p-3 mb-3 border-0">
                    <h6 class="text-muted small fw-bold">WAKTU SISTEM</h6>
                    <h5 class="fw-bold mb-0 text-primary">{{ date('d F Y') }}</h5>
                </div>
                <div class="card shadow-sm border-0 p-3">
                    <h6 class="fw-bold small text-uppercase mb-2">Live Monitor</h6>
                    <p class="text-muted small mb-0">Data diperbarui otomatis setiap 30 detik tanpa refresh halaman.</p>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            let table = $('#tableAttendance').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.dashboard') }}",
                    error: function (xhr, error, code) {
                        console.log(xhr.responseText); // Untuk debug jika ada error lagi
                    }
                },
                pageLength: 5,
                lengthMenu: [5, 10, 25],
                order: [], 
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'text-center' },
                    { data: 'intern_name', name: 'intern.name' },
                    { data: 'check_in', name: 'check_in', class: 'text-center fw-bold' },
                    { data: 'check_out', name: 'check_out', class: 'text-center fw-bold' },
                    { 
                        data: 'status', 
                        name: 'status',
                        class: 'text-center',
                        render: function(data) {
                            let val = data.toLowerCase();
                            let colors = { 'hadir': 'success', 'izin': 'warning', 'sakit': 'info', 'alpha': 'danger' };
                            let color = colors[val] || 'secondary';
                            return `<span class="badge bg-light-${color} text-${color} badge-status">${data}</span>`;
                        }
                    }
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "_MENU_",
                    info: "_TOTAL_ Absensi",
                    paginate: { next: "→", previous: "←" }
                }
            });

            // Live Update
            setInterval(function() { table.ajax.reload(null, false); }, 30000);
        });
    </script>
@endpush