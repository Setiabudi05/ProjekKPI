<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     * Kita atur ke /login, tetapi yang menentukan adalah metode register() di bawah.
     *
     * @var string
     */
    protected $redirectTo = '/login'; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * Default role untuk pengguna baru kita set 'user'.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'user', // Set role default untuk pengguna baru
            'password' => Hash::make($data['password']),
        ]);
    }
    
    /**
     * Handle a registration request for the application.
     * ⭐ METODE INI DI OVERRIDE UNTUK MENCEGAH AUTO-LOGIN DAN MENGALIHKAN KE LOGIN. ⭐
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // 1. Validasi data
        $this->validator($request->all())->validate();

        // 2. Buat user dan kirim event Registered
        event(new Registered($user = $this->create($request->all())));

        // 3. JANGAN LAKUKAN LOGIN ($this->guard()->login($user); DIHILANGKAN)

        // 4. Redirect ke halaman login dengan pesan sukses.
        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    // Redirect ke rute login.form dengan pesan sukses
                    : redirect()->route('login.form')
                        ->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    /**
     * Tampilkan formulir registrasi.
     * Ini memastikan view 'auth.register' dimuat.
     * * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); 
    }
}