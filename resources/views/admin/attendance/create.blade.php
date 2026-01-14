@extends('layouts.master')
@section('title', 'Input Absensi Manual')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb" style="font-size: 0.85rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.attendance.index') }}" class="text-muted">Rekap Absensi</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Input Manual</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Input Absensi Manual</h3>
            </div>
        </div>
    </div>
    <hr>
</div>

<section class="section">
    <div class="card border-0 shadow-sm col-lg-8">
        <div class="card-body">
            <form action="{{ route('admin.attendance.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Peserta <span class="text-danger">*</span></label>
                    <select name="intern_id" class="form-select @error('intern_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Peserta --</option>
                        @foreach($interns as $intern)
                            <option value="{{ $intern->id }}">{{ $intern->name }} ({{ $intern->school }})</option>
                        @endforeach
                    </select>
                    @error('intern_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jam Masuk</label>
                        <input type="time" name="check_in" class="form-control" value="08:00">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jam Keluar</label>
                        <input type="time" name="check_out" class="form-control" value="17:00">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status Kehadiran <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alpha">Alpha</option>
                    </select>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-light px-4 border">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Absensi</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection