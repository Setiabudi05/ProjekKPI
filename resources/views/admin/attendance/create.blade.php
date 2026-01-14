@extends('layouts.master')
@section('title', 'Input Absensi Manual')

@push('css')
    <style>
        .btn-primary { background-color: #435ebe; border-color: #435ebe; }
        .card { border: none; border-radius: 12px; }
        .form-label { font-size: 0.85rem; color: #4b5563; }
        .breadcrumb-item + .breadcrumb-item::before { content: "•"; }
    </style>
@endpush

@section('content')
<div class="page-heading mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="order-first">
            <h3 class="fw-bold text-dark mb-0">Input Absensi Manual</h3>
            <p class="text-muted small mb-0">Tambahkan catatan kehadiran peserta secara manual.</p>
        </div>
        <div class="order-last">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted small">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.attendance.index') }}" class="text-muted small">Rekap Absensi</a></li>
                    <li class="breadcrumb-item active small text-primary" aria-current="page">Input Manual</li>
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
                    <form action="{{ route('admin.attendance.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold text-uppercase small">Pilih Peserta <span class="text-danger">*</span></label>
                                <select name="intern_id" class="form-select shadow-none @error('intern_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Nama Peserta --</option>
                                    @foreach($interns as $intern)
                                        <option value="{{ $intern->id }}">{{ $intern->name }} ({{ $intern->school }})</option>
                                    @endforeach
                                </select>
                                @error('intern_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-uppercase small">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control shadow-none" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-uppercase small">Status Kehadiran <span class="text-danger">*</span></label>
                                <select name="status" class="form-select shadow-none" required>
                                    <option value="hadir">HADIR</option>
                                    <option value="izin">IZIN</option>
                                    <option value="sakit">SAKIT</option>
                                    <option value="alpha">ALPHA</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-uppercase small">Jam Masuk</label>
                                <input type="time" name="check_in" class="form-control shadow-none" value="08:00">
                                <small class="text-muted">Format 24 jam</small>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-uppercase small">Jam Keluar</label>
                                <input type="time" name="check_out" class="form-control shadow-none" value="17:00">
                                <small class="text-muted">Format 24 jam</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('admin.attendance.index') }}" class="btn btn-light px-4 border">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                                <i class="bi bi-save me-1"></i> Simpan Absensi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection