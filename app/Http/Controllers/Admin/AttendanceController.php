<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Intern;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Attendance::with('intern')->select('attendances.*');

            // Fitur Filter: Jika ada kiriman intern_id dari select2/dropdown
            if ($request->has('intern_id') && $request->intern_id != '') {
                $data->where('intern_id', $request->intern_id);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('intern_name', fn($row) => $row->intern->name ?? '-')

                ->editColumn('check_in', function ($row) {
                    return $row->check_in ? date('H:i', strtotime($row->check_in)) : '-';
                })
                ->editColumn('check_out', function ($row) {
                    return $row->check_out ? date('H:i', strtotime($row->check_out)) : '-';
                })
                ->editColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->date));
                })

                ->addColumn('action', function ($row) {
                    return '<div class="d-flex justify-content-center gap-1">
                                <a href="' . route('admin.attendance.edit', $row->id) . '" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" onclick="hapus(' . $row->id . ')" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Data untuk UI Pendukung
        $interns = Intern::all();
        $stats = [
            'total_peserta' => Intern::count(),
            'hadir_hari_ini' => Attendance::whereDate('date', Carbon::today())->where('status', 'hadir')->count()
        ];

        return view('admin.attendance.index', compact('interns', 'stats'));
    }

    public function create()
    {
        $interns = Intern::all();
        return view('admin.attendance.create', compact('interns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'intern_id' => 'required|exists:interns,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
        ]);

        Attendance::create($request->all());

        return redirect()->route('admin.attendance.index')->with('swal_success', 'Data absensi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $interns = Intern::all();
        return view('admin.attendance.edit', compact('attendance', 'interns'));
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $request->validate([
            'intern_id' => 'required|exists:interns,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
        ]);

        $attendance->update($request->all());

        return redirect()->route('admin.attendance.index')->with('swal_success', 'Data absensi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return response()->json(['success' => true, 'message' => 'Data absensi berhasil dihapus']);
    }
}