<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;        // Untuk menghitung Admin di tabel users
use App\Models\Intern;      // Untuk menghitung data Intern di tabel interns
use App\Models\Attendance;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // LOGIKA AJAX UNTUK MONITOR ABSENSI (SERVER-SIDE)
        if ($request->ajax()) {
            $data = Attendance::with('intern')
                ->whereDate('date', Carbon::today())
                ->select('attendances.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('intern_name', function($row) {
                    $name = $row->intern->name ?? 'User';
                    return '<div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name='.urlencode($name).'&background=random" class="avatar-table me-2" style="width:30px; border-radius:50%">
                                <div class="fw-bold">'.$name.'</div>
                            </div>';
                })
                ->editColumn('check_in', function($row) {
                    return $row->check_in ? date('H:i', strtotime($row->check_in)) : '--:--';
                })
                ->editColumn('check_out', function($row) {
                    return $row->check_out ? date('H:i', strtotime($row->check_out)) : '--:--';
                })
                ->editColumn('status', function($row) {
                    $val = strtolower($row->status);
                    $colors = ['hadir' => 'success', 'izin' => 'warning', 'sakit' => 'info', 'alpha' => 'danger'];
                    $color = $colors[$val] ?? 'secondary';
                    return '<span class="badge bg-light-'.$color.' text-'.$color.' text-uppercase" style="font-size:0.7rem">'.$row->status.'</span>';
                })
                ->rawColumns(['intern_name', 'status'])
                ->make(true);
        }

        // --- STATISTIK DASHBOARD (FIXED) ---
        
        // Mengambil total dari tabel 'interns' (Bukan tabel users)
        $totalInterns = Intern::count(); 

        // Menghitung admin saja dari tabel 'users'
        $totalAdmin = User::where('role', 'admin')->count(); 

        // Menghitung intern yang statusnya 'aktif' di tabel 'interns'
        $internsActive = Intern::where('status', 'aktif')->count(); 

        // Menghitung absensi hari ini
        $attendanceToday = Attendance::whereDate('date', Carbon::today())->count();

        return view('admin.dashboard', compact(
            'totalInterns', 
            'totalAdmin', 
            'internsActive', 
            'attendanceToday'
        ));
    }
}