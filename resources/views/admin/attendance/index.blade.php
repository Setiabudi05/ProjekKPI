@extends('layouts.master')
@section('title', 'Rekap Absensi Harian')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <style>
        .badge-status { font-size: 0.75rem; text-transform: uppercase; }
        .card-stats { border-left: 4px solid #435ebe; }
    </style>
@endpush

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb" style="font-size: 0.85rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Rekap Absensi</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Rekap Absensi Harian</h3>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary shadow-sm px-3 fw-bold">
                    <i class="bi bi-plus-circle-fill me-1"></i> Input Absensi Manual
                </a>
            </div>
        </div>
    </div>
</div>

<section class="section mt-4">
    <div class="row mb-3">
        <div class="col-6 col-md-3">
            <div class="card card-stats shadow-sm">
                <div class="card-body px-3 py-3">
                    <h6 class="text-muted font-semibold">Total Peserta</h6>
                    <h4 class="fw-bold mb-0">{{ $stats['total_peserta'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm" style="border-left: 4px solid #198754;">
                <div class="card-body px-3 py-3">
                    <h6 class="text-muted font-semibold">Hadir Hari Ini</h6>
                    <h4 class="fw-bold mb-0">{{ $stats['hadir_hari_ini'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white pb-0">
            <div class="row">
                <div class="col-md-4">
                    <label class="small fw-bold">Filter Nama Peserta:</label>
                    <select id="filter-intern" class="form-select form-select-sm">
                        <option value="">-- Semua Peserta --</option>
                        @foreach($interns as $intern)
                            <option value="{{ $intern->id }}">{{ $intern->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
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
            ajax: {
                url: "{{ route('admin.attendance.index') }}",
                data: function(d) {
                    d.intern_id = $('#filter-intern').val(); // Kirim ID peserta ke controller
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'text-center' },
                { data: 'date', name: 'date' },
                { data: 'intern_name', name: 'intern_name' },
                { data: 'check_in', name: 'check_in', class: 'text-center' },
                { data: 'check_out', name: 'check_out', class: 'text-center' },
                { 
                    data: 'status', 
                    render: function(data) {
                        let colors = { 'hadir': 'success', 'izin': 'warning', 'sakit': 'info', 'alpha': 'danger' };
                        let color = colors[data] || 'secondary';
                        return `<span class="badge bg-light-${color} text-${color} badge-status">${data}</span>`;
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center' }
            ]
        });

        // Trigger reload saat filter diubah
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
            confirmButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
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