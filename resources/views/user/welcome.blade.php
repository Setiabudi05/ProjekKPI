<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Absensi Magang</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css">
    
    <style>
        body {
            background-color: #f0f2f5;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        /* Style Sidebar */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding-top: 20px;
            position: sticky;
            top: 0;
            height: 100vh;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            color: #bdc3c7;
            padding: 15px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            border-left: 5px solid transparent;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            color: #fff;
            background-color: #34495e;
            border-left-color: #3498db;
        }
        .sidebar .fa-fw {
            margin-right: 10px;
        }

        /* Style Konten Utama */
        .content {
            flex-grow: 1;
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .card-action {
            background-color: #dbe4f3;
            border-left: 5px solid #007bff;
        }
        .btn-absen {
            font-weight: bold;
            letter-spacing: 1px;
            padding: 10px 40px;
        }
        /* Style untuk Card yang Lebih Kontras (Anti-Ajeg) */
        .card-contrast {
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        
        <div class="sidebar">
            <h4 class="text-center mb-4 text-white p-3">ABSENSI MAGANG</h4>
            <a href="{{ route('user.dashboard') }}" class="active">
                <i class="fas fa-tachometer-alt fa-fw"></i> Dashboard
            </a>
            <a href="#">
                <i class="fas fa-clipboard-check fa-fw"></i> Absensi
            </a>
            <a href="#">
                <i class="fas fa-user-circle fa-fw"></i> Profil
            </a>
            
            <div class="mt-5 mx-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="content">
            <h2 class="mb-4 text-dark fs-2 fw-bold">👋 Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-secondary mb-5">Ini adalah pusat informasi dan absensi harian Anda.</p>

            <div class="row g-4 mb-5">
                
                <div class="col-lg-6 col-md-12">
                    <div class="card card-action text-center h-100 p-4 border-primary border-3">
                        <h4 class="mb-4 text-primary fw-bolder">Aksi Absensi Hari Ini</h4>
                        
                        @php $status_absen = 'Belum Absen'; $tombol_text = 'Absen Masuk'; @endphp 

                        <button class="btn btn-primary btn-lg w-75 mb-3 btn-absen shadow-lg">{{ $tombol_text }}</button>
                        <p class="text-secondary small">Status saat ini: **{{ $status_absen }}**</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card bg-success text-white p-4 h-100 d-flex flex-column justify-content-between card-contrast">
                        <i class="fas fa-calendar-check fa-2x mb-3 opacity-75"></i>
                        <h5 class="opacity-75">Hadir Bulan Ini</h5>
                        <p class="fs-3 fw-bold mb-0">18/22 Hari</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-warning text-dark p-4 h-100 d-flex flex-column justify-content-between card-contrast">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3 opacity-75"></i>
                        <h5 class="opacity-75">Status Harian</h5>
                        <p class="fs-3 fw-bold mb-0">Belum Absen</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card p-4">
                        <h4 class="mb-4 text-dark"><i class="fas fa-history me-2"></i> Riwayat Absensi</h4>
                        <div class="table-responsive">
                            <table id="riwayatTable" class="table table-hover table-bordered" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Total Jam</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data dummy --}}
                                    <tr>
                                        <td>2023-12-04</td>
                                        <td>08:00</td>
                                        <td>17:00</td>
                                        <td>9 Jam</td>
                                        <td><span class="badge bg-success p-2">Hadir</span></td>
                                    </tr>
                                    <tr>
                                        <td>2023-12-03</td>
                                        <td>08:05</td>
                                        <td>17:00</td>
                                        <td>8 Jam 55 Min</td>
                                        <td><span class="badge bg-warning p-2">Terlambat</span></td>
                                    </tr>
                                    <tr>
                                        <td>2023-12-02</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><span class="badge bg-info p-2">Izin</span></td>
                                    </tr>
                                    <tr>
                                        <td>2023-12-01</td>
                                        <td>07:58</td>
                                        <td>17:01</td>
                                        <td>9 Jam 3 Min</td>
                                        <td><span class="badge bg-success p-2">Hadir</span></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.datatables.net/2.0.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#riwayatTable').DataTable({
                // Konfigurasi DataTables
                language: {
                    // Gunakan bahasa Indonesia
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                },
                columnDefs: [
                    { orderable: false, targets: [4] } // Non-aktifkan sorting pada kolom Status
                ],
                order: [[0, 'desc']] // Urutkan berdasarkan kolom Tanggal (kolom 0) secara descending
            });
        });
    </script>
</body>

</html>