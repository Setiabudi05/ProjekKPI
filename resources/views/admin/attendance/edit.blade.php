@extends('layouts.master')
@section('title', 'Edit Absensi')

@section('content')
<div class="page-heading">
    <h3 class="fw-bold">Edit Absensi: {{ $attendance->intern->name }}</h3>
    <hr>
</div>

<section class="section">
    <div class="card border-0 shadow-sm col-lg-8">
        <div class="card-body">
            <form action="{{ route('admin.attendance.update', $attendance->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Peserta <span class="text-danger">*</span></label>
                    <select name="intern_id" class="form-select @error('intern_id') is-invalid @enderror" required>
                        @foreach($interns as $intern)
                            <option value="{{ $intern->id }}" {{ $attendance->intern_id == $intern->id ? 'selected' : '' }}>
                                {{ $intern->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ $attendance->date }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jam Masuk</label>
                        <input type="time" name="check_in" class="form-control" value="{{ $attendance->check_in }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jam Keluar</label>
                        <input type="time" name="check_out" class="form-control" value="{{ $attendance->check_out }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status Kehadiran <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="hadir" {{ $attendance->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ $attendance->status == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ $attendance->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alpha" {{ $attendance->status == 'alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-light px-4 border">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Perbarui Absensi</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection