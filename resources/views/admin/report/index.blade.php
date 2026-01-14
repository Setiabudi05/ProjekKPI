@extends('layouts.master')
@section('title', 'Laporan Absensi Magang')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <style>
        /* Mengambil style dari kode Intern */
        .avatar-table { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; }
        .badge-count {
            width: 30px; height: 30px; display: inline-flex;
            align-items: center; justify-content: center;
            border-radius: 50%; font-weight: bold;
            font-size: 0.85rem;
        }
        /* Style tambahan untuk menyamakan tampilan badge light */
        .bg-light-success { background-color: #e8fadf !important; color: #71dd37 !important; }
        .bg-light-warning { background-color: #fff2e2 !important; color: #ffab00 !important; }
        .bg-light-info { background-color: #e7e7ff !important; color: #696cff !important; }
        .bg-light-danger { background-color: #ffe5e5 !important; color: #ff3e1d !important; }
    </style>
@endpush

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-7">
                {{-- Breadcrumb disamakan dengan Intern --}}
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb" style="font-size: 0.85rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Laporan Bulanan</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Laporan Rekapitulasi Bulanan</h3>
                <p class="text-muted mb-0">Total akumulasi kehadiran peserta magang berdasarkan periode.</p>
            </div>

            <div class="col-12 col-md-5 d-flex justify-content-md-end align-items-center mt-3 mt-md-0 gap-2">
                <button id="btn-print" class="btn btn-danger shadow-sm fw-bold">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak PDF
                </button>
            </div>
        </div>
    </div>
    <hr>
</div>

<section class="section">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pb-0">
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="small text-muted fw-bold">Peserta</label>
                    <select id="filter-peserta" class="form-select shadow-sm">
                        <option value="">Semua Peserta</option>
                        @foreach ($pesertas as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="small text-muted fw-bold">Bulan</label>
                    <select id="filter-bulan" class="form-select shadow-sm">
                        <option value="">Semua Periode</option>
                        @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $b)
                            <option value="{{ sprintf('%02d', $i+1) }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="small text-muted fw-bold">Tahun</label>
                    <select id="filter-tahun" class="form-select shadow-sm">
                        @for ($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle report-table" id="report-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Peserta</th>
                            <th>Sekolah/Instansi</th>
                            <th class="text-center">Hadir</th>
                            <th class="text-center">Izin</th>
                            <th class="text-center">Sakit</th>
                            <th class="text-center">Alpha</th>
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

<script>
$(document).ready(function () {
    let table = $('#report-table').DataTable({
        processing: true, 
        serverSide: true,
        ajax: {
            url: "{{ route('admin.laporan.index') }}",
            data: function (d) {
                d.month = $('#filter-bulan').val();
                d.year = $('#filter-tahun').val();
                d.user_id = $('#filter-peserta').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'text-center' },
            { 
                data: 'name', 
                name: 'name', 
                render: function(data) {
                    // Menambahkan Avatar seperti di halaman Intern
                    return `<div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data)}&background=random" class="avatar-table me-2">
                                <div class="fw-bold">${data}</div>
                            </div>`;
                }
            },
            { data: 'school', name: 'school' },
            { 
                data: 'hadir', 
                name: 'hadir', 
                class: 'text-center', 
                render: d => `<span class="badge bg-light-success text-success badge-count border border-success">${d}</span>` 
            },
            { 
                data: 'izin', 
                name: 'izin', 
                class: 'text-center', 
                render: d => `<span class="badge bg-light-warning text-warning badge-count border border-warning">${d}</span>` 
            },
            { 
                data: 'sakit', 
                name: 'sakit', 
                class: 'text-center', 
                render: d => `<span class="badge bg-light-info text-info badge-count border border-info">${d}</span>` 
            },
            { 
                data: 'alpha', 
                name: 'alpha', 
                class: 'text-center', 
                render: d => `<span class="badge bg-light-danger text-danger badge-count border border-danger">${d}</span>` 
            }
        ]
    });

    $('#filter-bulan, #filter-tahun, #filter-peserta').change(() => table.draw());

    $('#btn-print').on('click', function() {
        let query = $.param({
            month: $('#filter-bulan').val(),
            year: $('#filter-tahun').val(),
            user_id: $('#filter-peserta').val()
        });
        window.open("{{ route('admin.laporan.pdf') }}?" + query, '_blank');
    });
});
</script>
@endpush