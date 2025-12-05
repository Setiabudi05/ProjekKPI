<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman Laporan Absensi dengan filter.
     */
    public function index(Request $request)
    {
        // Query untuk mengambil semua data absensi
        $query = Attendance::with('intern') 
            ->latest('date');

        // Logika filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Logika filter berdasarkan tanggal (bisa dikembangkan di view)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }


        $reports = $query->paginate(20); 

        // Daftar status untuk filter di view
        $statuses = ['Hadir', 'Izin', 'Sakit', 'Alpha'];

        return view('admin.laporan.index', compact('reports', 'statuses'));
    }
}