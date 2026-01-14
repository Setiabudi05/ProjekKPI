@extends('layouts.master')
@section('title', 'Edit Absensi')

@push('css')
    <style>
        .btn-primary { background-color: #435ebe; border-color: #435ebe; }
        .card { border: none; border-radius: 12px; }
        .form-label { font-size: 0.85rem; color: #4b5563; }
        .breadcrumb-item + .breadcrumb-item::before { content: "•"; }
        .edit-info-banner { background-color: #f0f5ff; border-left: 4px solid #435ebe; padding: 15px; border-radius: 8px; }
    </style>
@endpush

@section('content')
<div class="page-heading mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="order-first">
            <h3 class="fw-bold text-dark mb-0">Edit Absensi</h3>
            <p class="text-muted small mb-0">Perbarui data kehadiran peserta magang.</p>
        </div>
        <div class="order-last">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted small">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.attendance.index') }}" class="text-muted small">Rekap Absensi</a></li>
                    <li class="breadcrumb-item active small text-primary" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="edit-info-banner d-flex align-items-center mb-4">
                        <i class="bi bi-info-circle-fill text-primary fs-4 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Mengubah absensi: {{ $attendance->intern->name }}</h6>
                            <small class="text-muted">Instansi: {{ $attendance->intern->school }}</small>
                        </div>
                    </div>

                    <form action="{{ route('admin.attendance.update', $attendance->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold text-uppercase small">Nama Peserta <span class="text-danger">*</span></label>
                                <select name="intern_id" class="form-select shadow-none @error('intern_id') is-invalid @enderror" required>
                                    @foreach($interns as $intern)
                                        <option value="{{ $intern->id }}" {{ $attendance->intern_id == $intern->id ? 'selected' : '' }}>
                                            {{ $intern->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-uppercase small">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control shadow-none" value="{{ $attendance->date }}" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-uppercase small">Status Kehadiran <span class="text-danger">*</span></label>
                                <select name="status" class="form-select shadow-none" required>
                                    <option value="hadir" {{ $attendance->status == 'hadir' ? 'selected' : '' }}>HADIR</option>
                                    <option value="izin" {{ $attendance->status == 'izin' ? 'selected' : '' }}>IZIN</option>
                                    <option value="sakit" {{ $attendance->status == 'sakit' ? 'selected' : '' }}>SAKIT</option>
                                    <option value="alpha" {{ $attendance->status == 'alpha' ? 'selected' : '' }}>ALPHA</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-uppercase small">Jam Masuk</label>
                                <input type="time" name="check_in" class="form-control shadow-none" value="{{ $attendance->check_in }}">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-uppercase small">Jam Keluar</label>
                                <input type="time" name="check_out" class="form-control shadow-none" value="{{ $attendance->check_out }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('admin.attendance.index') }}" class="btn btn-light px-4 border">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                                <i class="bi bi-arrow-repeat me-1"></i> Perbarui Absensi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection