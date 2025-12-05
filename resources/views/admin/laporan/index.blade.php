@extends('admin.layouts.master')

@section('title', 'Laporan Absensi')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Absensi</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Cetak Laporan
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="form-inline">
                <label class="my-1 mr-2" for="statusFilter">Status:</label>
                <select name="status" id="statusFilter" class="custom-select my-1 mr-sm-2">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary my-1">Tampilkan</button>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary my-1 ml-2">Reset Filter</a>
            </form>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center table-flush w-100" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Magang</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $report->intern->name }}</td>
                                <td>{{ $report->date }}</td>
                                <td>{{ $report->time_in ?? '-' }}</td>
                                <td>{{ $report->time_out ?? '-' }}</td>
                                <td><span class="badge badge-{{ $report->status == 'Hadir' ? 'success' : ($report->status == 'Izin' || $report->status == 'Sakit' ? 'warning' : 'danger') }}">{{ $report->status }}</span></td>
                                <td>{{ $report->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data absensi yang tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="mt-3">
                {{ $reports->links() }}
            </div>
        </div>
    </div>

@endsection