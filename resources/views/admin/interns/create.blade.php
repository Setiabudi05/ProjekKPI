@extends('layouts.master')

@section('title', 'Tambah Peserta Magang')

@push('css')
    <style>
        /* Aksen warna Indigo untuk membedakan dari SysGRA */
        .btn-primary { background-color: #435ebe; border-color: #435ebe; }
        .text-primary { color: #435ebe !important; }
        .card { border: none; border-radius: 12px; }
        .form-label { font-size: 0.85rem; color: #4b5563; }
        .breadcrumb-item + .breadcrumb-item::before { content: "•"; }
    </style>
@endpush

@section('content')
<div class="page-heading mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="order-first">
            <h3 class="fw-bold text-dark mb-0"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Peserta</h3>
            <p class="text-muted small mb-0">Daftarkan mahasiswa atau siswa magang baru ke sistem.</p>
        </div>
        <div class="order-last">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted small">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.interns.index') }}" class="text-muted small">Peserta Magang</a></li>
                    <li class="breadcrumb-item active small text-primary" aria-current="page">Tambah Baru</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0 pt-4">
                    <h5 class="fw-bold text-dark mb-0">Formulir Data Magang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.interns.store') }}" method="POST" data-parsley-validate>
                        @csrf
                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold text-uppercase small">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name"
                                    class="form-control shadow-none @error('name') is-invalid @enderror"
                                    placeholder="Nama lengkap peserta" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold text-uppercase small">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email"
                                    class="form-control shadow-none @error('email') is-invalid @enderror"
                                    placeholder="contoh@email.com" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="student_id" class="form-label fw-bold text-uppercase small">NIM / NIS <span class="text-danger">*</span></label>
                                <input type="text" id="student_id" name="student_id"
                                    class="form-control shadow-none @error('student_id') is-invalid @enderror"
                                    placeholder="Nomor Induk Mahasiswa/Siswa" value="{{ old('student_id') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="school" class="form-label fw-bold text-uppercase small">Asal Sekolah / Universitas <span class="text-danger">*</span></label>
                                <input type="text" id="school" name="school"
                                    class="form-control shadow-none @error('school') is-invalid @enderror"
                                    placeholder="Nama Instansi" value="{{ old('school') }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="major" class="form-label fw-bold text-uppercase small">Jurusan <span class="text-danger">*</span></label>
                                <input type="text" id="major" name="major"
                                    class="form-control shadow-none @error('major') is-invalid @enderror"
                                    placeholder="Contoh: Teknik Informatika" value="{{ old('major') }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="position" class="form-label fw-bold text-uppercase small">Posisi Magang <span class="text-danger">*</span></label>
                                <input type="text" id="position" name="position"
                                    class="form-control shadow-none @error('position') is-invalid @enderror"
                                    placeholder="Contoh: Web Developer" value="{{ old('position') }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label fw-bold text-uppercase small">Status Awal <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select shadow-none @error('status') is-invalid @enderror" required>
                                    <option value="aktif" selected>Aktif</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="period" class="form-label fw-bold text-uppercase small">Periode Magang <span class="text-danger">*</span></label>
                                <input type="text" id="period" name="period"
                                    class="form-control shadow-none @error('period') is-invalid @enderror"
                                    placeholder="Contoh: Januari 2026 - April 2026" value="{{ old('period') }}" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('admin.interns.index') }}" class="btn btn-light px-4 border text-muted small fw-bold">Batal</a>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-light px-4 border small fw-bold">Reset</button>
                                <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                                    <i class="bi bi-save me-1"></i> Simpan Peserta
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://parsleyjs.org/dist/parsley.min.js"></script>
@endpush