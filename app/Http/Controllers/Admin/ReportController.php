<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data untuk dropdown agar tidak error 'Undefined variable $pesertas'
        $pesertas = Intern::orderBy('name', 'asc')->get();

        $month = $request->get('month');
        $year = $request->get('year', date('Y'));
        $userId = $request->get('user_id');

        if ($request->ajax()) {
            $query = Intern::with([
                'attendances' => function ($q) use ($month, $year) {
                    if ($month) {
                        $q->whereMonth('date', $month);
                    }
                    $q->whereYear('date', $year);
                }
            ]);

            if ($userId) {
                $query->where('id', $userId);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                // DISESUAIKAN: Menggunakan "Hadir" sesuai dengan isi database Anda
                ->addColumn('hadir', fn($row) => $row->attendances->where('status', 'Hadir')->count())
                ->addColumn('izin', fn($row) => $row->attendances->where('status', 'Izin')->count())
                ->addColumn('sakit', fn($row) => $row->attendances->where('status', 'Sakit')->count())
                ->addColumn('alpha', fn($row) => $row->attendances->where('status', 'Alpha')->count())
                ->make(true);
        }

        return view('admin.report.index', compact('pesertas', 'month', 'year'));
    }

    public function exportPdf(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year', 2026);
        $userId = $request->get('user_id');

        // Mengambil data peserta beserta detail absensinya
        $query = Intern::with([
            'attendances' => function ($q) use ($month, $year) {
                if ($month) {
                    $q->whereMonth('date', $month);
                }
                $q->whereYear('date', $year);
                $q->orderBy('date', 'asc'); // Urutkan berdasarkan tanggal tertua
            }
        ]);

        if ($userId) {
            $query->where('id', $userId);
        }

        $reports = $query->get();

        // Label periode untuk judul
        $periodeLabel = $month ? date('F', mktime(0, 0, 0, $month, 1)) . " $year" : "Seluruh Periode Magang ($year)";

        $pdf = Pdf::loadView('admin.report.pdf', compact('reports', 'periodeLabel'));
        return $pdf->stream("Laporan_Detail_Absensi.pdf");
    }
}