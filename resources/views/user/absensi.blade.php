@extends('layouts.user')

@section('title', 'Absensi Harian')

@push('css')
<style>
    .icon-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')

@php
    $checkInTime = $attendance?->check_in
        ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i')
        : '--:--';

    $checkOutTime = $attendance?->check_out
        ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i')
        : '--:--';

    $alreadyCheckIn = !empty($attendance?->check_in);
    $alreadyCheckOut = !empty($attendance?->check_out);

    $isTerlambat = $status === 'Terlambat';
    $isIzin = in_array($status, ['Izin', 'Sakit']);

    $statusBadge = match($status) {
        'Hadir' => 'badge bg-success',
        'Terlambat' => 'badge bg-warning text-dark',
        'Izin', 'Sakit' => 'badge bg-info',
        'Alpha' => 'badge bg-danger',
        default => 'badge bg-secondary'
    };
@endphp

<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Absensi Harian</h4>
                    <p class="mb-0 text-muted">Data terisi otomatis saat halaman dibuka</p>
                </div>
                <div class="text-end">
                    <div class="badge bg-light text-dark border">{{ $hari }}, {{ $tanggal }}</div>
                    <div class="small text-muted">Jam kerja: {{ $work_hours['start'] }} - {{ $work_hours['end'] }}</div>
                </div>
            </div>

            @foreach (['success' => 'success', 'warning' => 'warning', 'info' => 'info'] as $key => $type)
                @if(session($key))
                    <div class="alert alert-{{ $type }} mb-3">
                        {{ session($key) }}
                    </div>
                @endif
            @endforeach

            <div class="card shadow-sm rounded-4 mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="text-muted small">Status hari ini</div>
                            <h5 class="mb-0">Absensi: <span class="{{ $statusBadge }}">{{ $status }}</span></h5>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small">Nama</div>
                            <h6 class="mb-0">{{ $intern->name ?? 'Pengguna' }}</h6>
                        </div>
                    </div>

                    @if($isTerlambat)
                    <div class="alert alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Keterangan Terlambat:</strong> Anda melakukan check-in setelah jam kerja dimulai ({{ $work_hours['start'] }}). Status Anda tercatat sebagai <strong>Terlambat</strong>.
                    </div>
                    @endif

                    @if (!$attendance)
                    <div class="alert alert-warning">
                        Kamu belum melakukan absensi hari ini
                        </div>
                    @else
                        <div class="alert alert-success">
                        Status: <span class="{{ $statusBadge }}">{{ $status }}</span>
                    </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 border rounded-3 bg-light {{ $isTerlambat ? 'border-warning' : '' }}">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Jam Masuk</span>
                                    <i class="fas fa-door-open {{ $isTerlambat ? 'text-warning' : 'text-success' }}"></i>
                                </div>
                                <div class="h4 mb-1">{{ $checkInTime }}</div>
                                @if($isTerlambat)
                                    <small class="text-warning"><i class="fas fa-clock me-1"></i>Terlambat</small>
                                @else
                                    <small class="text-success">{{ $alreadyCheckIn ? 'Sudah check-in' : 'Belum check-in' }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 border rounded-3 bg-light">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Jam Pulang</span>
                                    <i class="fas fa-door-closed text-danger"></i>
                                </div>
                                <div class="h4 mb-1">{{ $checkOutTime }}</div>
                                <small class="text-danger">{{ $alreadyCheckOut ? 'Sudah check-out' : 'Belum check-out' }}</small>
                            </div>
                        </div>
                    </div>

                    @if(!$alreadyCheckIn && !$isIzin)
                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
                        <form method="POST" action="{{ route('user.absensi.checkin') }}">
                            @csrf
                            <button class="btn btn-success px-4">
                                <i class="fas fa-play-circle me-2"></i>Check In
                            </button>
                        </form>

                        <button type="button" class="btn btn-info px-4" data-bs-toggle="modal" data-bs-target="#izinModal">
                            <i class="fas fa-file-alt me-2"></i>Ajukan Izin
                        </button>
                    </div>
                    @elseif($alreadyCheckIn && !$alreadyCheckOut)
                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
                        <form method="POST" action="{{ route('user.absensi.checkout') }}">
                            @csrf
                            <button class="btn btn-danger px-4">
                                <i class="fas fa-stop-circle me-2"></i>Check Out
                            </button>
                        </form>
                    </div>
                    @endif

                    <div class="alert alert-info mt-3 mb-0">
                        <small class="mb-0 d-block"><i class="fas fa-info-circle me-2"></i>Petunjuk:</small>
                        <small class="d-block text-muted">- Masuk sebelum {{ $work_hours['start'] }} untuk tercatat <strong>Hadir</strong>.</small>
                        <small class="d-block text-muted">- Masuk setelah {{ $work_hours['start'] }} akan tercatat sebagai <strong>Terlambat</strong>.</small>
                        <small class="d-block text-muted">- Jika tidak bisa masuk kerja, ajukan <strong>Izin</strong> atau <strong>Sakit</strong> agar tidak tercatat Alpha.</small>
                        <small class="d-block text-muted">- Lakukan check-out sebelum {{ $work_hours['end'] }} untuk menutup absensi.</small>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-primary text-white mr-2"><i class="fas fa-sun"></i></div>
                                <h6 class="mb-0">Masuk Kerja</h6>
                            </div>
                            <p class="text-muted small mb-0">Check-in pada rentang jam kerja agar status tercatat Hadir.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-success text-white mr-2"><i class="fas fa-check-circle"></i></div>
                                <h6 class="mb-0">Pulang Kerja</h6>
                            </div>
                            <p class="text-muted small mb-0">Check-out untuk menutup absensi hari ini dan menghindari status terbuka.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-danger text-white mr-2"><i class="fas fa-exclamation-triangle"></i></div>
                                <h6 class="mb-0">Tidak Masuk</h6>
                            </div>
                            <p class="text-muted small mb-0">Jika tidak hadir, segera ajukan izin agar tidak tercatat Alpha.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Izin -->
<div class="modal fade" id="izinModal" tabindex="-1" aria-labelledby="izinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="izinModalLabel">Ajukan Izin / Sakit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('user.absensi.izin') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="">Pilih jenis...</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Masukkan alasan izin atau sakit..." required></textarea>
                        <small class="text-muted">Jelaskan alasan Anda tidak dapat masuk kerja hari ini.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ajukan Izin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection