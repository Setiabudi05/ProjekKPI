@extends('layouts.master')
@section('title', 'Data Peserta Magang')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <style>
        .swal-custom-popup { font-size: 0.85rem !important; }
        .avatar-table { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; }
    </style>
@endpush

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-7">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb" style="font-size: 0.85rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Peserta Magang</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Manajemen Peserta Magang</h3>
                <p class="text-muted mb-0">Kelola data mahasiswa/siswa yang sedang melaksanakan magang.</p>
            </div>

            <div class="col-12 col-md-5 d-flex justify-content-md-end align-items-center mt-3 mt-md-0 gap-2">
                <select id="filter-status" class="form-select shadow-sm" style="width: 150px;">
                    <option value="">Semua Status</option>
                    <option value="aktif" selected>Aktif</option>
                    <option value="selesai">Selesai</option>
                </select>
                
                <a href="{{ route('admin.interns.create') }}" class="btn btn-primary shadow-sm px-3 fw-bold">
                    <i class="bi bi-person-plus-fill me-1"></i> Tambah Peserta
                </a>
            </div>
        </div>
    </div>
    <hr>
</div>

<section class="section">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle interns-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Peserta</th>
                            <th>Email</th>
                            <th>Instansi/Sekolah</th>
                            <th>Posisi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
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
        let table = $('.interns-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.interns.index') }}", 
                data: function (d) { 
                    d.status = $('#filter-status').val(); 
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'text-center' },
                { 
                    data: 'name', 
                    name: 'name', 
                    render: function(data) {
                        return `<div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data)}&background=random" class="avatar-table me-2">
                                    <div class="fw-bold">${data}</div>
                                </div>`;
                    }
                },
                { data: 'email', name: 'email' },
                { data: 'school', name: 'school' }, // Diubah dari institution ke school agar sesuai DB
                { data: 'position', name: 'position' },    
                { 
                    data: 'status', 
                    name: 'status', 
                    class: 'text-center',
                    render: function(data) {
                        let color = data === 'aktif' ? 'success' : 'secondary';
                        return `<span class="badge bg-light-${color} text-${color} text-uppercase" style="font-size:0.7rem">${data}</span>`;
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#filter-status').on('change', function () { 
            table.draw(); 
        });
    });

    function hapus(id) {
        Swal.fire({
            title: "Hapus Peserta?",
            text: "Seluruh data absensi peserta ini juga akan terhapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/data-magang') }}/" + id, 
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        Swal.fire("Terhapus!", res.message, "success");
                        $('.interns-table').DataTable().ajax.reload();
                    }
                });
            }
        });
    }
</script>

@if(session('swal_success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('swal_success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@endpush