<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern; 
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InternController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Intern::query();

            // Logika Filter Status
            if ($request->filled('status')) {
                $data->where('status', $request->status);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->orderColumn('DT_RowIndex', false) // Menonaktifkan sorting pada kolom No agar tidak error SQL
                ->addColumn('action', function($row) {
                    return '<div class="d-flex justify-content-center gap-1">
                                <a href="'.route('admin.interns.edit', $row->id).'" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" onclick="hapus('.$row->id.')" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.interns.index');
    }

    public function create()
    {
        return view('admin.interns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:interns,email',
            'student_id' => 'required|string|unique:interns,student_id|max:50',
            'school'     => 'required|string|max:255', 
            'major'      => 'required|string|max:255',
            'period'     => 'required|string|max:255',
            'position'   => 'required|string|max:255',
            'status'     => 'required|in:aktif,selesai',
        ]);

        Intern::create($request->all());

        return redirect()->route('admin.interns.index')->with('swal_success', 'Peserta magang berhasil didaftarkan!');
    }

    public function edit($id) 
    {
        $data_magang = Intern::findOrFail($id);
        return view('admin.interns.edit', compact('data_magang'));
    }

    public function update(Request $request, $id)
    {
        $intern = Intern::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:interns,email,' . $intern->id,
            'student_id' => 'required|string|unique:interns,student_id,' . $intern->id,
            'school'     => 'required|string|max:255',
            'major'      => 'required|string|max:255',
            'period'     => 'required|string|max:255',
            'position'   => 'required|string|max:255',
            'status'     => 'required|in:aktif,selesai',
        ]);

        $intern->update($request->all());

        return redirect()->route('admin.interns.index')->with('swal_success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $intern = Intern::findOrFail($id);
            $intern->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data peserta magang telah dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data.'
            ]);
        }
    }
}