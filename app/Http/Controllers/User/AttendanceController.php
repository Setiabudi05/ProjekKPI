<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $intern = $this->resolveIntern($user);

        $today = now()->toDateString();
        $attendance = Attendance::where('intern_id', $intern->id)
            ->where('date', $today)
            ->first();

        $status = $attendance?->status ?? 'Belum Absen';

        return view('user.absensi', [
            'hari' => now()->translatedFormat('l'),
            'tanggal' => now()->format('d-m-Y'),
            'attendance' => $attendance,
            'status' => $status,
            'intern' => $intern,
            // Jam kerja dasar yang akan ditampilkan sebagai panduan
            'work_hours' => [
                'start' => '08:00',
                'end' => '17:00',
            ],
        ]);
    }

    public function checkIn()
    {
        $user = Auth::user();
        $intern = $this->resolveIntern($user);
        $today = now()->toDateString();
        $workStartTime = '08:00'; // Jam kerja mulai

        $attendance = Attendance::firstOrCreate(
            [
                'intern_id' => $intern->id,
                'date' => $today,
            ],
            [
                'status' => 'Hadir',
            ]
        );

        if ($attendance->time_in) {
            return back()->with('info', 'Kamu sudah melakukan check-in hari ini.');
        }

        $currentTime = now()->format('H:i');
        $isLate = strtotime($currentTime) > strtotime($workStartTime);
        $status = $isLate ? 'Terlambat' : 'Hadir';

        $attendance->update([
            'time_in' => now()->format('H:i:s'),
            'status' => $status,
        ]);

        $message = $isLate 
            ? 'Check-in berhasil dicatat pada ' . $currentTime . ' (Terlambat)'
            : 'Check-in berhasil dicatat pada ' . $currentTime;

        return back()->with('success', $message);
    }

    public function checkOut()
    {
        $user = Auth::user();
        $intern = $this->resolveIntern($user);
        $today = now()->toDateString();

        $attendance = Attendance::where('intern_id', $intern->id)
            ->where('date', $today)
            ->first();

        if (! $attendance) {
            return back()->with('warning', 'Silakan check-in terlebih dahulu sebelum check-out.');
        }

        if (! $attendance->time_in) {
            return back()->with('warning', 'Silakan check-in terlebih dahulu sebelum check-out.');
        }

        if ($attendance->time_out) {
            return back()->with('info', 'Kamu sudah melakukan check-out hari ini.');
        }

        $attendance->update([
            'time_out' => now()->format('H:i:s'),
            'status' => $attendance->status ?? 'Hadir',
        ]);

        return back()->with('success', 'Check-out berhasil dicatat pada ' . now()->format('H:i'));
    }

    /**
     * Submit izin untuk hari ini
     */
    public function submitIzin(Request $request)
    {
        $user = Auth::user();
        $intern = $this->resolveIntern($user);
        $today = now()->toDateString();

        $request->validate([
            'reason' => 'required|string|max:500',
            'type' => 'required|in:Izin,Sakit',
        ]);

        $attendance = Attendance::firstOrCreate(
            [
                'intern_id' => $intern->id,
                'date' => $today,
            ],
            [
                'status' => $request->type,
                'notes' => $request->reason,
            ]
        );

        // Jika sudah ada attendance, update status dan notes
        if ($attendance->time_in) {
            return back()->with('warning', 'Anda sudah melakukan check-in hari ini. Tidak bisa mengajukan izin.');
        }

        $attendance->update([
            'status' => $request->type,
            'notes' => $request->reason,
        ]);

        return back()->with('success', 'Izin berhasil diajukan untuk hari ini.');
    }

    /**
     * Menemukan atau membuat entri intern untuk user yang sedang login.
     * Ini memastikan absensi dapat direlasikan ke data magang yang unik.
     */
    private function resolveIntern($user): Intern
    {
        $studentId = $user->student_id ?? 'USR-' . $user->id;
        
        return Intern::firstOrCreate(
            [
                'student_id' => $studentId,
            ],
            [
                'name' => $user->name ?? 'Pengguna',
                'school' => '-',
            ]
        );
    }
}