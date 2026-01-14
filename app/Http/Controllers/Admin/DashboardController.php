<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
                    // Menggunakan Avatar Bulat seperti di fitur Intern
                    return '<div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name='.urlencode($name).'&background=random" class="avatar-table me-2">
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
                    // Badge Light seperti di fitur Intern
                    $val = strtolower($row->status);
                    $colors = ['hadir' => 'success', 'izin' => 'warning', 'sakit' => 'info', 'alpha' => 'danger'];
                    $color = $colors[$val] ?? 'secondary';
                    return '<span class="badge bg-light-'.$color.' text-'.$color.' text-uppercase" style="font-size:0.7rem">'.$row->status.'</span>';
                })
                ->rawColumns(['intern_name', 'status'])
                ->make(true);
        }

        // STATISTIK DASHBOARD
        $totalInterns = User::where('role', 'user')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $attendanceToday = Attendance::whereDate('date', Carbon::today())->count();
        $internsActive = User::where('role', 'user')->count(); 

        $latestInterns = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalInterns', 
            'totalAdmin', 
            'internsActive', 
            'attendanceToday',
            'latestInterns'
        ));
    }
}