<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Fakultas;
use App\Models\Gedung;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    private function authorizeSuperAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403, 'Akses hanya untuk super admin.');
    }

    public function index()
    {
        $this->authorizeSuperAdmin();

        $users = User::with(['cabang', 'fakultas', 'gedung'])
            ->latest()
            ->paginate(15);

        return view('super-admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.users.form', [
            'user' => new User(),
            'cabangs' => Cabang::orderBy('nama_cabang')->get(),
            'fakultas' => Fakultas::orderBy('nama_fakultas')->get(),
            'gedungs' => Gedung::orderBy('nama_gedung')->get(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        $data = $this->validateRequest($request);

        // Normalize fields based on role/admin_level (business case).
        if (in_array($data['role'], ['mahasiswa', 'dosen', 'staff'], true)) {
            $fakultas = Fakultas::findOrFail($data['id_fakultas']);
            $data['id_cabang'] = $fakultas->id_cabang;
        }

        if ($data['role'] === 'admin') {
            if (($data['admin_level'] ?? null) === 'fakultas') {
                $fakultas = Fakultas::findOrFail($data['id_fakultas']);
                $data['id_cabang'] = $fakultas->id_cabang;
                $data['id_gedung'] = null;
            } elseif (($data['admin_level'] ?? null) === 'gedung') {
                $gedung = Gedung::findOrFail($data['id_gedung']);
                $data['id_fakultas'] = $gedung->id_fakultas;
                $data['id_cabang'] = $gedung->id_cabang;
                // Keep id_admin_level as is.
            }
        }

        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.users.form', [
            'user' => $user,
            'cabangs' => Cabang::orderBy('nama_cabang')->get(),
            'fakultas' => Fakultas::orderBy('nama_fakultas')->get(),
            'gedungs' => Gedung::orderBy('nama_gedung')->get(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeSuperAdmin();

        $data = $this->validateRequest($request, $user);

        // Normalize fields based on role/admin_level (business case).
        if (in_array($data['role'], ['mahasiswa', 'dosen', 'staff'], true)) {
            $fakultas = Fakultas::findOrFail($data['id_fakultas']);
            $data['id_cabang'] = $fakultas->id_cabang;
        }

        if ($data['role'] === 'admin') {
            if (($data['admin_level'] ?? null) === 'fakultas') {
                $fakultas = Fakultas::findOrFail($data['id_fakultas']);
                $data['id_cabang'] = $fakultas->id_cabang;
                $data['id_gedung'] = null;
            } elseif (($data['admin_level'] ?? null) === 'gedung') {
                $gedung = Gedung::findOrFail($data['id_gedung']);
                $data['id_fakultas'] = $gedung->id_fakultas;
                $data['id_cabang'] = $gedung->id_cabang;
            }
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->authorizeSuperAdmin();

        if ($user->is(auth()->user())) {
            return back()->withErrors([
                'delete' => 'Akun super admin yang sedang login tidak dapat dihapus.',
            ]);
        }

        $user->delete();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    private function validateRequest(Request $request, ?User $user = null): array
    {
        $passwordRules = $user
            ? ['nullable', 'confirmed', Password::defaults()]
            : ['required', 'confirmed', Password::defaults()];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'password' => $passwordRules,
            'role' => ['required', Rule::in(['mahasiswa', 'dosen', 'staff', 'admin', 'super_admin'])],
            'admin_level' => ['nullable', Rule::in(['gedung', 'fakultas', 'super'])],
            'id_cabang' => ['nullable', 'exists:cabang,id_cabang'],
            'id_fakultas' => ['nullable', 'exists:fakultas,id_fakultas'],
            'id_gedung' => ['nullable', 'exists:gedung,id_gedung'],
            'nim_nip' => ['required', 'string', 'max:100'],
        ]);

        // Conditional checks to match business rules.
        $role = $data['role'];
        $adminLevel = $data['admin_level'] ?? null;

        if ($role === 'super_admin') {
            if ($adminLevel !== 'super') {
                throw ValidationException::withMessages([
                    'admin_level' => 'Untuk super_admin, admin_level harus bernilai "super".',
                ]);
            }
        }

        if ($role === 'admin') {
            if (!in_array($adminLevel, ['gedung', 'fakultas'], true)) {
                throw ValidationException::withMessages([
                    'admin_level' => 'Untuk role admin, admin_level harus diisi: gedung atau fakultas.',
                ]);
            }

            if ($adminLevel === 'fakultas' && empty($data['id_fakultas'])) {
                throw ValidationException::withMessages([
                    'id_fakultas' => 'id_fakultas wajib untuk admin_level=fakultas.',
                ]);
            }

            if ($adminLevel === 'gedung' && empty($data['id_gedung'])) {
                throw ValidationException::withMessages([
                    'id_gedung' => 'id_gedung wajib untuk admin_level=gedung.',
                ]);
            }
        }

        if (in_array($role, ['mahasiswa', 'dosen', 'staff'], true)) {
            if (!empty($adminLevel)) {
                throw ValidationException::withMessages([
                    'admin_level' => 'admin_level tidak digunakan untuk role mahasiswa/dosen/staff.',
                ]);
            }

            if (empty($data['id_fakultas'])) {
                throw ValidationException::withMessages([
                    'id_fakultas' => 'id_fakultas wajib untuk role mahasiswa/dosen/staff.',
                ]);
            }
        }

        return $data;
    }
}
