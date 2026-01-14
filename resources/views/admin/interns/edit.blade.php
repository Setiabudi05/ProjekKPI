@extends('layouts.master')

@section('title', 'Edit Peserta: ' . $data_magang->name)

@push('css')
    <style>
        .btn-primary { background-color: #435ebe; border-color: #435ebe; }
        .text-primary { color: #435ebe !important; }
        .card { border: none; border-radius: 12px; }
        .form-label { font-size: 0.85rem; color: #4b5563; }
        .breadcrumb-item + .breadcrumb-item::before { content: "•"; }
        .edit-profile-header { background: #fcfcfd; border-radius: 10px; padding: 15px; border: 1px solid #f1f5f9; }
    </style>
@endpush

@section('content')
<div class="page-heading mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="order-first">
            <h3 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Profil</h3>
            <p class="text-muted small mb-0">Perbarui informasi detail peserta magang.</p>
        </div>
        <div class="order-last">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted small">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.interns.index') }}" class="text-muted small">Peserta Magang</a></li>
                    <li class="breadcrumb-item active small text-primary" aria-current="page">Edit Peserta</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="edit-profile-header d-flex align-items-center mb-4 shadow-sm">
                        <div class="me-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($data_magang->name) }}&background=435ebe&color=fff" class="rounded" width="50">
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Mengubah data: {{ $data_magang->name }}</h6>
                            <p class="text-muted small mb-0">Terdaftar pada: {{ $data_magang->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm py-2">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.interns.update', $data_magang->id) }}" method="POST" data-parsley-validate>
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold text-uppercase small">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" 
                                    class="form-control shadow-none @error('name') is-invalid @enderror" 
                                    value="{{ old('name', $data_magang->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold text-uppercase small">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" 
                                    class="form-control shadow-none @error('email') is-invalid @enderror" 
                                    value="{{ old('email', $data_magang->email) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="student_id" class="form-label fw-bold text-uppercase small">NIM / NIS <span class="text-danger">*</span></label>
                                <input type="text" id="student_id" name="student_id" 
                                    class="form-control shadow-none" 
                                    value="{{ old('student_id', $data_magang->student_id) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="school" class="form-label fw-bold text-uppercase small">Asal Sekolah / Kampus <span class="text-danger">*</span></label>
                                <input type="text" id="school" name="school" 
                                    class="form-control shadow-none" 
                                    value="{{ old('school', $data_magang->school) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="major" class="form-label fw-bold text-uppercase small">Jurusan <span class="text-danger">*</span></label>
                                <input type="text" id="major" name="major" 
                                    class="form-control shadow-none" 
                                    value="{{ old('major', $data_magang->major) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="position" class="form-label fw-bold text-uppercase small">Posisi Magang <span class="text-danger">*</span></label>
                                <input type="text" id="position" name="position" 
                                    class="form-control shadow-none" 
                                    value="{{ old('position', $data_magang->position) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label fw-bold text-uppercase small">Status Magang <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select shadow-none" required>
                                    <option value="aktif" {{ old('status', $data_magang->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="selesai" {{ old('status', $data_magang->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="period" class="form-label fw-bold text-uppercase small">Periode Magang <span class="text-danger">*</span></label>
                                <input type="text" id="period" name="period" 
                                    class="form-control shadow-none" 
                                    value="{{ old('period', $data_magang->period) }}" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('admin.interns.index') }}" class="btn btn-light px-4 border text-muted small fw-bold">Batal</a>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-light px-4 border small fw-bold">Reset</button>
                                <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
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