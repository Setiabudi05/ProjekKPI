@extends('layouts.master')
@section('title', 'Data Peserta Magang')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <style>
        /* Aksen Warna Indigo untuk membedakan dengan SysGRA */
        .btn-primary { background-color: #435ebe; border-color: #435ebe; }
        .btn-primary:hover { background-color: #394fa3; border-color: #394fa3; }
        .text-primary { color: #435ebe !important; }
        
        .card { border: none; border-radius: 12px; }
        .card-header { border-bottom: 1px solid #f8f9fa; padding: 1.5rem; }
        
        /* Merapikan Header Tabel */
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
        
        /* Styling Avatar Kotak Rounded */
        .avatar-box {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; color: white;
            background: linear-gradient(135deg, #435ebe, #6c8ef2);
            font-size: 0.85rem;
        }

        .breadcrumb-item + .breadcrumb-item::before { content: "•"; }
        
        /* Merapikan search box datatables */
        .dataTables_filter input {
            border-radius: 8px;
            padding: 5px 10px;
            border: 1px solid #dce7f1;
        }
    </style>
@endpush

@section('content')
<div class="page-heading mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="order-first">
            <h3 class="fw-bold text-dark mb-0">Manajemen Peserta</h3>
            <p class="text-muted small mb-0">Kelola data mahasiswa/siswa yang sedang melaksanakan magang.</p>
        </div>
        <div class="order-last">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted small">Dashboard</a></li>
                    <li class="breadcrumb-item active small text-primary" aria-current="page">Peserta Magang</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-bold">Daftar Intern</h5>
                </div>
                <div class="col-auto d-flex gap-2">
                    <select id="filter-status" class="form-select form-select-sm shadow-none" style="width: 130px;">
                        <option value="">Semua Status</option>
                        <option value="aktif" selected>Aktif</option>
                        <option value="selesai">Selesai</option>
                    </select>
                    <a href="{{ route('admin.interns.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baru
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle interns-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="30%">Identitas Peserta</th>
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
            // Mengatur posisi elemen tabel (length, filter, table, info, pagination)
            dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
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
                    render: function(data, type, row) {
                        // Membuat inisial nama untuk avatar jika gambar tidak ada
                        let initials = data.split(' ').map(n => n[0]).join('').toUpperCase().substring(0,2);
                        return `<div class="d-flex align-items-center">
                                    <div class="avatar-box me-3">${initials}</div>
                                    <div>
                                        <div class="fw-bold mb-0 text-dark">${data}</div>
                                        <small class="text-muted" style="font-size: 0.75rem">${row.email}</small>
                                    </div>
                                </div>`;
                    }
                },
                { data: 'school', name: 'school' },
                { 
                    data: 'position', 
                    render: function(data) {
                        return `<span class="badge bg-light-primary text-primary px-2" style="font-size: 0.7rem">
                                    <i class="bi bi-briefcase-fill me-1"></i>${data}
                                </span>`;
                    }
                },
                { 
                    data: 'status', 
                    class: 'text-center',
                    render: function(data) {
                        let color = data === 'aktif' ? 'success' : 'secondary';
                        return `<span class="badge bg-${color} text-white border-0 px-3 py-2" style="font-size:0.65rem; border-radius: 50px;">
                                    ${data.toUpperCase()}
                                </span>`;
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center' }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari nama...",
                lengthMenu: "_MENU_ data per halaman",
            }
        });

        $('#filter-status').on('change', function () { 
            table.draw(); 
        });
    });

    function hapus(id) {
        Swal.fire({
            title: "Hapus Peserta?",
            text: "Data absensi terkait juga akan terhapus secara permanen.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#435ebe",
            cancelButtonColor: "#f3f4f6",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "<span style='color:#4b5563'>Batal</span>"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/data-magang') }}/" + id, 
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        Swal.fire("Terhapus!", "Data peserta telah berhasil dihapus.", "success");
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