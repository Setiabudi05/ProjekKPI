<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $intern = $this->resolveIntern($user);

        return view('user.profil', [
            'user' => $user,
            'intern' => $intern,
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $intern = $this->resolveIntern($user);

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
            'student_id' => 'nullable|string|max:50',
            'jobdesk' => 'nullable|string|max:1000',
        ]);

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'student_id' => $request->student_id,
        ]);

        // Update data intern (sinkronisasi)
        $intern->update([
            'name' => $request->name,
            'student_id' => $request->student_id ?? $intern->student_id,
            'jobdesk' => $request->jobdesk,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Menemukan atau membuat entri intern untuk user yang sedang login.
     */
    private function resolveIntern($user): Intern
    {
        return Intern::firstOrCreate(
            [
                // Gunakan student_id user jika ada, jika tidak buat ID sementara
                'student_id' => $user->student_id ?? 'USR-' . $user->id,
            ],
            [
                'name' => $user->name ?? 'Pengguna',
                'school' => '-',
                'jobdesk' => null,
            ]
        );
    }
}