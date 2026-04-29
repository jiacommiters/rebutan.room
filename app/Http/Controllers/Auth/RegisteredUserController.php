<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Super admin/admin dibuat melalui panel CRUD, registrasi publik hanya untuk mahasiswa/dosen/staff.
        return view('auth.register', [
            'fakultas' => Fakultas::with('cabang')
                ->orderBy('nama_fakultas')
                ->get(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Business rules user: tiap pengguna punya identitas akademik & afiliasi kampus.
            'role' => ['required', 'in:mahasiswa,dosen,staff'],
            'nim_nip' => ['required', 'string', 'max:100'],
            'id_fakultas' => ['required', 'exists:fakultas,id_fakultas'],
        ]);

        $fakultas = Fakultas::findOrFail($request->id_fakultas);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            'role' => $request->role,
            'nim_nip' => $request->nim_nip,
            'id_fakultas' => $fakultas->id_fakultas,
            'id_cabang' => $fakultas->id_cabang, // lokasi kampus (sesuai relasi fakultas)
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
