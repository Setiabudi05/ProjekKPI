@extends('layouts.master')

@section('title', 'Edit Peserta: ' . $data_magang->name)

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb" style="font-size: 0.85rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.interns.index') }}" class="text-muted">Peserta Magang</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Edit Peserta</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Peserta Magang</h3>
                <p class="text-muted mb-0 small">Perbarui data profil magang: <strong>{{ $data_magang->name }}</strong></p>
            </div>

            <div class="col-12 col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.interns.index') }}" class="text-muted small fw-bold text-decoration-none">
                    <i class="bi bi-chevron-left"></i> Kembali ke daftar peserta
                </a>
            </div>
        </div>
    </div>
    <hr class="mb-4">
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0 pt-4">
                    <h5 class="fw-bold text-primary mb-0">Formulir Pembaruan Data</h5>
                </div>
                <div class="card-body">
                    {{-- Menampilkan Error Validasi Jika Ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.interns.update', $data_magang->id) }}" method="POST" data-parsley-validate>
                        @csrf
                        @method('PUT')
                        
                        <div class="row mt-3">
                            {{-- Nama Lengkap --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" 
                                    class="form-control shadow-sm @error('name') is-invalid @enderror" 
                                    value="{{ old('name', $data_magang->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat Email --}}
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" 
                                    class="form-control shadow-sm @error('email') is-invalid @enderror" 
                                    value="{{ old('email', $data_magang->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NIM / NIS --}}
                            <div class="col-md-6 mb-3">
                                <label for="student_id" class="form-label fw-bold">NIM / NIS <span class="text-danger">*</span></label>
                                <input type="text" id="student_id" name="student_id" 
                                    class="form-control shadow-sm @error('student_id') is-invalid @enderror" 
                                    value="{{ old('student_id', $data_magang->student_id) }}" required>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Asal Sekolah / Kampus --}}
                            <div class="col-md-6 mb-3">
                                <label for="school" class="form-label fw-bold">Asal Sekolah / Universitas <span class="text-danger">*</span></label>
                                <input type="text" id="school" name="school" 
                                    class="form-control shadow-sm @error('school') is-invalid @enderror" 
                                    value="{{ old('school', $data_magang->school) }}" required>
                                @error('school')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jurusan --}}
                            <div class="col-md-4 mb-3">
                                <label for="major" class="form-label fw-bold">Jurusan <span class="text-danger">*</span></label>
                                <input type="text" id="major" name="major" 
                                    class="form-control shadow-sm @error('major') is-invalid @enderror" 
                                    value="{{ old('major', $data_magang->major) }}" required>
                                @error('major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Posisi Magang --}}
                            <div class="col-md-4 mb-3">
                                <label for="position" class="form-label fw-bold">Posisi Magang <span class="text-danger">*</span></label>
                                <input type="text" id="position" name="position" 
                                    class="form-control shadow-sm @error('position') is-invalid @enderror" 
                                    value="{{ old('position', $data_magang->position) }}" required>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status Magang --}}
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label fw-bold">Status Magang <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select shadow-sm @error('status') is-invalid @enderror" required>
                                    <option value="aktif" {{ old('status', $data_magang->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="selesai" {{ old('status', $data_magang->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Periode Magang --}}
                            <div class="col-md-12 mb-3">
                                <label for="period" class="form-label fw-bold">Periode Magang <span class="text-danger">*</span></label>
                                <input type="text" id="period" name="period" 
                                    class="form-control shadow-sm @error('period') is-invalid @enderror" 
                                    value="{{ old('period', $data_magang->period) }}" 
                                    placeholder="Contoh: 08 September - 20 Desember 2026" required>
                                @error('period')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('admin.interns.index') }}" class="btn btn-secondary shadow-sm px-4 fw-bold">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-light px-4 fw-bold border">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary px-4 fw-bold shadow">
                                    <i class="bi bi-arrow-repeat me-1"></i> Perbarui Data
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