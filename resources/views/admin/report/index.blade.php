@extends('layouts.master')
@section('title', 'Laporan Absensi Magang')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <style>
        /* Aksen Warna Indigo */
        .btn-primary { background-color: #435ebe; border-color: #435ebe; }
        .text-primary { color: #435ebe !important; }
        
        /* Card & Table Styling */
        .card { border: none; border-radius: 12px; }
        .table thead th { 
            background-color: #fcfcfd;
            text-transform: uppercase; 
            font-size: 0.7rem; 
            letter-spacing: 0.8px;
            font-weight: 700;
            color: #94a3b8;
            padding: 12px 15px;
        }

        /* Avatar Box Styling (Indigo Version) */
        .avatar-box {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; color: white;
            background: linear-gradient(135deg, #435ebe, #6c8ef2);
            font-size: 0.8rem;
        }

        /* Badge Bulat untuk Akumulasi */
        .badge-count {
            width: 32px; height: 32px; display: inline-flex;
            align-items: center; justify-content: center;
            border-radius: 50%; font-weight: bold;
            font-size: 0.85rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .breadcrumb-item + .breadcrumb-item::before { content: "•"; }

        /* Custom Colors for Report */
        .bg-light-success { background-color: #e8fadf !important; color: #71dd37 !important; }
        .bg-light-warning { background-color: #fff2e2 !important; color: #ffab00 !important; }
        .bg-light-info { background-color: #e7e7ff !important; color: #696cff !important; }
        .bg-light-danger { background-color: #ffe5e5 !important; color: #ff3e1d !important; }
    </style>
@endpush

@section('content')
<div class="page-heading mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="order-first">
            <h3 class="fw-bold text-dark mb-0">Rekapitulasi Bulanan</h3>
            <p class="text-muted small mb-0">Akumulasi kehadiran peserta magang berdasarkan periode.</p>
        </div>
        <div class="order-last">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted small">Dashboard</a></li>
                    <li class="breadcrumb-item active small text-primary" aria-current="page">Laporan Bulanan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom border-light py-3">
            <div class="row align-items-center g-3">
                <div class="col-md-9">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted text-uppercase mb-1 d-block">Filter Peserta</label>
                            <select id="filter-peserta" class="form-select form-select-sm shadow-none">
                                <option value="">Semua Peserta</option>
                                @foreach ($pesertas as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted text-uppercase mb-1 d-block">Pilih Bulan</label>
                            <select id="filter-bulan" class="form-select form-select-sm shadow-none">
                                <option value="">Semua Periode</option>
                                @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $b)
                                    <option value="{{ sprintf('%02d', $i+1) }}">{{ $b }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted text-uppercase mb-1 d-block">Pilih Tahun</label>
                            <select id="filter-tahun" class="form-select form-select-sm shadow-none">
                                @for ($y = date('Y'); $y >= 2024; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-md-end mt-4 mt-md-0 pt-2">
                    <button id="btn-print" class="btn btn-danger btn-sm px-4 shadow-sm rounded-pill fw-bold">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body pt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle report-table" id="report-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="30%">Nama Peserta</th>
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
        dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
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
                    let initials = data.split(' ').map(n => n[0]).join('').toUpperCase().substring(0,2);
                    return `<div class="d-flex align-items-center">
                                <div class="avatar-box me-3">${initials}</div>
                                <div class="fw-bold text-dark">${data}</div>
                            </div>`;
                }
            },
            { data: 'school', name: 'school' },
            { 
                data: 'hadir', 
                class: 'text-center', 
                render: d => `<span class="badge bg-light-success text-success badge-count border border-success">${d}</span>` 
            },
            { 
                data: 'izin', 
                class: 'text-center', 
                render: d => `<span class="badge bg-light-warning text-warning badge-count border border-warning">${d}</span>` 
            },
            { 
                data: 'sakit', 
                class: 'text-center', 
                render: d => `<span class="badge bg-light-info text-info badge-count border border-info">${d}</span>` 
            },
            { 
                data: 'alpha', 
                class: 'text-center', 
                render: d => `<span class="badge bg-light-danger text-danger badge-count border border-danger">${d}</span>` 
            }
        ],
        language: {
            search: "",
            searchPlaceholder: "Cari peserta...",
            lengthMenu: "_MENU_ data",
        }
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