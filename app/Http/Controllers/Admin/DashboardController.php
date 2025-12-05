<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Intern; 
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // 1. Total Anak Magang
        $totalMagang = Intern::count();

        // 2. Hadir Hari Ini
        $hadirHariIni = Attendance::where('date', $today)
            ->where('status', 'Hadir')
            ->whereNotNull('time_in')
            ->count();

        // 3. Izin / Sakit
        $izinSakit = Attendance::where('date', $today)
            ->whereIn('status', ['Izin', 'Sakit'])
            ->count();
            
        // 4. Alpha (Total Magang - (Hadir + Izin + Sakit))
        $alpha = $totalMagang - ($hadirHariIni + $izinSakit);
        // Pastikan Alpha tidak negatif
        $alpha = max(0, $alpha);

        // Riwayat Absensi Hari Ini (Data Dummy sementara sebelum kita implementasi penuh)
        $riwayatAbsensi = Attendance::where('date', $today)
            ->with('intern')
            ->take(5) // Ambil 5 data terbaru
            ->get()
            ->map(function($att, $key) {
                return [
                    'no' => $key + 1,
                    'nama' => $att->intern->name,
                    'tanggal' => $att->date,
                    'masuk' => $att->time_in ?? '-',
                    'pulang' => $att->time_out ?? '-',
                    'status' => $att->status,
                    'badge_class' => $att->status == 'Hadir' ? 'badge-success' : ($att->status == 'Izin' || $att->status == 'Sakit' ? 'badge-warning' : 'badge-danger'),
                ];
            })->toArray(); // Konversi ke array untuk ditampilkan di view

        $data = [
            'total_magang' => $totalMagang, 
            'hadir_hari_ini' => $hadirHariIni, 
            'izin_sakit' => $izinSakit,
            'alpha' => $alpha,
            'riwayat_absensi' => $riwayatAbsensi,
        ];

        return view('admin.dashboard', $data); 
    }
}