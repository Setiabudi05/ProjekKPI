@extends('admin.layouts.master')

@section('title', 'Data Anak Magang')

@section('styles')
    <!-- Datatables CSS -->
    {{-- Memastikan link ini mengambil aset dari folder public/assets --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Anak Magang</h1>
        <div>
            <!-- Link ke halaman tambah data -->
            <a href="{{ route('admin.interns.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Anak Magang</a>
            <button class="btn btn-primary btn-sm" onclick="window.print()"><i class="fas fa-print"></i> Cetak Data</button>
        </div>
    </div>

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ Session::get('success') }}
        </div>
    @endif

    <!-- Card Tabel -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataMagangTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIS/NIM</th> 
                            <th>Sekolah/Universitas</th>
                            <th>Jurusan</th>
                            <th>Periode Magang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($interns as $intern)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $intern->name }}</td>
                            <td>{{ $intern->student_id }}</td> 
                            <td>{{ $intern->school }}</td>
                            <td>{{ $intern->major }}</td>
                            <td>{{ $intern->period }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.interns.edit', $intern->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                
                                <!-- Tombol Hapus dengan Form -->
                                <form action="{{ route('admin.interns.destroy', $intern->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $intern->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data anak magang yang tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Datatables JS Libraries -->
    {{-- Mengambil aset Datatables dari folder public/assets dan CDN --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Cek apakah jQuery tersedia (kadang-kadang jQuery dimuat setelah datatables)
            if (typeof $.fn.DataTable !== 'undefined') {
                 $('#dataMagangTable').DataTable({
                    "pageLength": 10,
                    "lengthChange": false,
                    "ordering": true,
                    "language": {
                         "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json" // Tambahkan bahasa Indonesia
                    }
                });
            }
        });
    </script>
@endsection