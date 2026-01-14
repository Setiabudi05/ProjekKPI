@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Profil Saya</h4>
                    <p class="mb-0 text-muted">Kelola data pribadi dan jobdesk magang Anda</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('user.profil.update') }}">
                @csrf
                @method('PUT')

                <!-- Data Pribadi -->
                <div class="card shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Pribadi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                                       placeholder="Contoh: 081234567890">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="student_id" class="form-label">NIS/NIM</label>
                                <input type="text" class="form-control @error('student_id') is-invalid @enderror" 
                                       id="student_id" name="student_id" value="{{ old('student_id', $user->student_id) }}" 
                                       placeholder="Nomor Induk Siswa/Mahasiswa">
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                       id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3" 
                                          placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jobdesk Magang -->
                <div class="card shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Jobdesk Magang</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="jobdesk" class="form-label">Deskripsi Jobdesk</label>
                            <textarea class="form-control @error('jobdesk') is-invalid @enderror" 
                                      id="jobdesk" name="jobdesk" rows="5" 
                                      placeholder="Jelaskan tugas dan tanggung jawab Anda selama magang...">{{ old('jobdesk', $intern->jobdesk) }}</textarea>
                            <small class="text-muted">Contoh: Mengembangkan aplikasi web menggunakan Laravel, melakukan testing, dokumentasi, dll.</small>
                            @error('jobdesk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Magang (Read-only) -->
                <div class="card shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Magang</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Sekolah/Universitas</label>
                                <div class="form-control-plaintext">{{ $intern->school ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Student ID</label>
                                <div class="form-control-plaintext">{{ $intern->student_id ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="d-flex justify-content-end gap-2 mb-4">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection