@extends('layouts.master')

@section('title', 'Dashboard - Absensi Magang')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <style>
        /* Konsistensi Identitas Indigo */
        .text-primary { color: #435ebe !important; }
        .bg-primary { background-color: #435ebe !important; }
        
        /* Card Styling */
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .card-stats-primary { border-left: 5px solid #435ebe; }
        .card-stats-success { border-left: 5px solid #198754; }
        .card-stats-info { border-left: 5px solid #0dcaf0; }
        .card-stats-danger { border-left: 5px solid #dc3545; }
        
        /* FIX: Pencarian (Search Bar) Putih Bersih */
        .dataTables_filter input, 
        .input-group.bg-light {
            background-color: #ffffff !important; 
            border: 1px solid #e2e8f0 !important; 
            box-shadow: none !important;
            border-radius: 8px !important;
        }

        /* FIX: Merapikan Ikon agar Benar-benar di Tengah */
        .stats-icon {
            width: 54px !important;
            height: 54px !important;
            border-radius: 14px;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-shrink: 0;
        }

        .stats-icon i {
            font-size: 1.6rem !important;
            line-height: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* FIX: Header Tabel Tanpa Latar Belakang Abu-abu */
        #tableAttendance thead tr {
            background-color: transparent !important;
            border-bottom: 2px solid #f1f5f9 !important;
        }

        #tableAttendance thead th {
            background-color: transparent !important;
            color: #64748b !important; /* Warna teks abu gelap yang rapi */
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 15px !important;
            border-top: none !important;
        }

        /* Variasi Warna Background Ikon */
        .bg-light-primary { background-color: #e7e7ff !important; }
        .bg-light-success { background-color: #e8fadf !important; }
        .bg-light-info { background-color: #e0f2ff !important; }
        .bg-light-danger { background-color: #ffe5e5 !important; }
        
        .breadcrumb-item + .breadcrumb-item::before { content: "•"; color: #adb5bd; }
        
        /* Animasi Live Pulse */
        .pulse-live {
            width: 10px; height: 10px;
            background: #198754;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 rgba(25, 135, 84, 0.4);
            animation: pulse-green 2s infinite;
        }
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(25, 135, 84, 0); }
            100% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
        }
    </style>
@endpush

@section('content')
<div class="page-heading mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="order-first">
            <h3 class="fw-bold text-dark mb-0">Ringkasan Aktivitas</h3>
            <p class="text-muted small mb-0">Pantau kehadiran intern secara real-time.</p>
        </div>
        <div class="order-last">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted small text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active small text-primary" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-md-3 mb-4">
                    <div class="card card-stats-primary h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-light-primary me-3">
                                    <i class="bi bi-people-fill text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Total Intern</h6>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalInterns }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card card-stats-info h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-light-info me-3">
                                    <i class="bi bi-person-check-fill text-info"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Aktif</h6>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $internsActive }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card card-stats-success h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-light-success me-3">
                                    <i class="bi bi-calendar-check text-success"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Hadir</h6>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $attendanceToday }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card card-stats-danger h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-light-danger me-3">
                                    <i class="bi bi-shield-lock text-danger"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Admin</h6>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalAdmin }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Monitor Absensi Hari Ini</h5>
                    <div class="small fw-bold text-success d-flex align-items-center">
                        <span class="pulse-live me-2"></span> LIVE MONITORING
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tableAttendance" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">No</th>
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
            <div class="card bg-primary text-white text-center p-4 mb-4 border-0 shadow-sm">
                <h6 class="small fw-bold mb-2 opacity-75">WAKTU SISTEM</h6>
                <h5 class="fw-bold mb-1">{{ date('d F Y') }}</h5>
                <div id="digitalClock" class="fs-4 fw-light">00:00:00</div>
            </div>

            <div class="card border-0 shadow-sm p-4 bg-light">
                <div class="d-flex align-items-center mb-3">
                    <div class="stats-icon bg-white shadow-sm me-3" style="width: 40px !important; height: 40px !important;">
                        <i class="bi bi-broadcast text-primary" style="font-size: 1.1rem !important;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Live Status</h6>
                </div>
                <p class="text-muted small mb-0 lh-base text-start">
                    Data absensi diperbarui otomatis setiap 30 detik tanpa perlu menyegarkan halaman.
                </p>
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
            function updateClock() {
                let now = new Date();
                let h = String(now.getHours()).padStart(2, '0');
                let m = String(now.getMinutes()).padStart(2, '0');
                let s = String(now.getSeconds()).padStart(2, '0');
                $('#digitalClock').text(`${h}:${m}:${s}`);
            }
            setInterval(updateClock, 1000);
            updateClock();

            let table = $('#tableAttendance').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.dashboard') }}",
                pageLength: 5,
                dom: 't<"d-flex justify-content-between align-items-center mt-3 small"ip>',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'text-center' },
                    { data: 'intern_name', name: 'intern.name', render: d => `<span class="fw-bold text-dark">${d}</span>` },
                    { data: 'check_in', name: 'check_in', class: 'text-center fw-bold text-primary' },
                    { data: 'check_out', name: 'check_out', class: 'text-center fw-bold text-primary' },
                    { 
                        data: 'status', 
                        class: 'text-center',
                        render: function(data) {
                            let val = data.toLowerCase();
                            let colors = { 'hadir': 'success', 'izin': 'warning', 'sakit': 'info', 'alpha': 'danger' };
                            let color = colors[val] || 'secondary';
                            return `<span class="badge bg-light-${color} text-${color} fw-bold" style="font-size: 0.65rem; border-radius: 50px; padding: 0.5em 1em;">${data.toUpperCase()}</span>`;
                        }
                    }
                ],
                language: {
                    info: "Menampilkan _TOTAL_ data absensi",
                    paginate: { next: "→", previous: "←" }
                }
            });

            setInterval(function() { table.ajax.reload(null, false); }, 30000);
        });
    </script>
@endpush