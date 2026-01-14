@extends('layouts.master')
@section('title', 'Rekap Absensi Harian')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <style>
        /* Aksen Warna Indigo */
        .btn-primary { background-color: #435ebe; border-color: #435ebe; }
        .btn-primary:hover { background-color: #394fa3; border-color: #394fa3; }
        .text-primary { color: #435ebe !important; }
        
        /* Card Styling */
        .card { border: none; border-radius: 12px; }
        .card-stats { border-left: 4px solid #435ebe; }
        .card-stats-success { border-left: 4px solid #198754; }
        
        /* Header Tabel Styling */
        .table thead th { 
            background-color: #fcfcfd;
            text-transform: uppercase; 
            font-size: 0.7rem; 
            letter-spacing: 0.8px;
            font-weight: 700;
            color: #94a3b8;
            padding: 12px 15px;
            border-top: none;
        }

        .breadcrumb-item + .breadcrumb-item::before { content: "•"; }

        /* Merapikan search box datatables */
        .dataTables_filter input {
            border-radius: 8px;
            padding: 5px 10px;
            border: 1px solid #dce7f1;
        }
        
        .badge-status { font-size: 0.7rem; padding: 0.5em 1em; border-radius: 50px; }
    </style>
@endpush

@section('content')
<div class="page-heading mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="order-first">
            <h3 class="fw-bold text-dark mb-0">Rekap Absensi Harian</h3>
            <p class="text-muted small mb-0">Pantau kehadiran harian peserta magang secara real-time.</p>
        </div>
        <div class="order-last">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted small">Dashboard</a></li>
                    <li class="breadcrumb-item active small text-primary" aria-current="page">Rekap Absensi</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    {{-- Ringkasan Statistik --}}
    <div class="row mb-4">
        <div class="col-6 col-md-3">
            <div class="card card-stats shadow-sm">
                <div class="card-body px-4 py-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Total Peserta</h6>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['total_peserta'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-stats-success shadow-sm">
                <div class="card-body px-4 py-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Hadir Hari Ini</h6>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['hadir_hari_ini'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <div style="min-width: 200px;">
                            <label class="small fw-bold text-muted text-uppercase mb-1 d-block">Filter Peserta:</label>
                            <select id="filter-intern" class="form-select form-select-sm shadow-none">
                                <option value="">-- Semua Peserta --</option>
                                @foreach($interns as $intern)
                                    <option value="{{ $intern->id }}">{{ $intern->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill">
                        <i class="bi bi-plus-circle-fill me-1"></i> Input Absensi Manual
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle attendance-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Nama Peserta</th>
                            <th class="text-center">Jam Masuk</th>
                            <th class="text-center">Jam Keluar</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="100px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        let table = $('.attendance-table').DataTable({
            processing: true,
            serverSide: true,
            dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
            ajax: {
                url: "{{ route('admin.attendance.index') }}",
                data: function(d) {
                    d.intern_id = $('#filter-intern').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'text-center' },
                { data: 'date', name: 'date' },
                { 
                    data: 'intern_name', 
                    name: 'intern_name',
                    render: function(data) {
                        return `<span class="fw-bold text-dark">${data}</span>`;
                    }
                },
                { data: 'check_in', name: 'check_in', class: 'text-center' },
                { data: 'check_out', name: 'check_out', class: 'text-center' },
                { 
                    data: 'status', 
                    render: function(data) {
                        let colors = { 'hadir': 'success', 'izin': 'warning', 'sakit': 'info', 'alpha': 'danger' };
                        let color = colors[data] || 'secondary';
                        return `<span class="badge bg-${color} text-white badge-status">${data.toUpperCase()}</span>`;
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center' }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari data...",
                lengthMenu: "_MENU_ data",
            }
        });

        $('#filter-intern').change(function() {
            table.ajax.reload();
        });
    });

    function hapus(id) {
        Swal.fire({
            title: "Hapus Absensi?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#435ebe",
            cancelButtonColor: "#f3f4f6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "<span style='color:#4b5563'>Batal</span>"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/rekap-absensi') }}/" + id,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        Swal.fire({ icon: "success", title: "Terhapus!", text: res.message, timer: 1500, showConfirmButton: false });
                        $('.attendance-table').DataTable().ajax.reload();
                    },
                    error: function () {
                        Swal.fire("Error!", "Gagal menghapus data.", "error");
                    }
                });
            }
        });
    }
</script>
@endpush