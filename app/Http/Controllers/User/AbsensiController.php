<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon; // Penting: Import Carbon
use Illuminate\Support\Facades\Auth; // Gunakan Facade untuk menghindari error Intelephense

class AbsensiController extends Controller
{
    public function index()
    {
        // Tetapkan sebagai objek Carbon (jangan langsung toDateString)
        // Agar bisa menggunakan method ->translatedFormat() di bawah nanti
        $today = Carbon::today(); 
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Ambil ID intern dari user atau fallback ke user_id
        $internId = $user->intern_id ?? $user->id;

        // Cari data absensi hari ini
        $attendance = Attendance::where('intern_id', $internId)
                        ->whereDate('date', $today->toDateString())
                        ->first();

        // Cek Status
        $status = $attendance->status ?? 'Belum Absen';

        // Format Tampilan (Membutuhkan objek Carbon)
        $hari = $today->translatedFormat('l'); // l = Nama hari lengkap
        $tanggal = $today->translatedFormat('d F Y'); // d F Y = 14 Januari 2026

        // Jam kerja statis
        $work_hours = [
            'start' => '08:00',
            'end'   => '16:00',
        ];

        return view('user.absensi', compact(
            'attendance',
            'status',
            'hari',
            'tanggal',
            'work_hours'
        ));
    }
}