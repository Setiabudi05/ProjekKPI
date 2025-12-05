<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Intern; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InternController extends Controller
{
    /**
     * Menampilkan daftar anak magang (READ - Index).
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Ambil semua data magang, diurutkan berdasarkan nama
        $interns = Intern::orderBy('name')->get(); 
        
        return view('admin.interns.index', compact('interns'));
    }

    /**
     * Menampilkan form untuk menambah anak magang baru (CREATE).
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.interns.create');
    }

    /**
     * Menyimpan anak magang baru ke database (STORE).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:interns,student_id|max:50',
            'school' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'period' => 'required|string|max:255',
        ]);

        // Buat record baru di database
        Intern::create([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'school' => $request->school,
            'major' => $request->major,
            'period' => $request->period,
        ]);

        Session::flash('success', 'Data anak magang berhasil ditambahkan!');
        return redirect()->route('admin.interns.index');
    }

    /**
     * Menampilkan form untuk mengedit anak magang (EDIT).
     *
     * @param  \App\Models\Intern  $data_magang
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Intern $data_magang) 
    {
        // $data_magang diisi otomatis oleh Laravel karena Model Binding
        return view('admin.interns.edit', compact('data_magang'));
    }

    /**
     * Memperbarui data anak magang di database (UPDATE).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Intern  $data_magang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Intern $data_magang)
    {
        // Validasi, pastikan student_id unik kecuali untuk record ini sendiri
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:interns,student_id,' . $data_magang->id . '|max:50',
            'school' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'period' => 'required|string|max:255',
        ]);

        // Perbarui record di database
        $data_magang->update([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'school' => $request->school,
            'major' => $request->major,
            'period' => $request->period,
        ]);

        Session::flash('success', 'Data anak magang berhasil diperbarui!');
        return redirect()->route('admin.interns.index');
    }

    /**
     * Menghapus anak magang dari database (DELETE).
     *
     * @param  \App\Models\Intern  $data_magang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Intern $data_magang)
    {
        $data_magang->delete();
        Session::flash('success', 'Data anak magang berhasil dihapus!');
        return redirect()->route('admin.interns.index');
    }
}