<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Kampus;
use Illuminate\Http\Request;

class CabangManagementController extends Controller
{
    private function authorizeSuperAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403, 'Akses hanya untuk super admin.');
    }

    public function index()
    {
        $this->authorizeSuperAdmin();

        $cabang = Cabang::with('kampus')
            ->orderByDesc('id_cabang')
            ->paginate(15);

        return view('super-admin.cabang.index', compact('cabang'));
    }

    public function create()
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.cabang.form', [
            'item' => new Cabang(),
            'isEdit' => false,
            'kampus' => Kampus::orderBy('nama_kampus')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        Cabang::create($this->validateRequest($request));

        return redirect()->route('super-admin.cabang.index')
            ->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function edit(Cabang $cabang)
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.cabang.form', [
            'item' => $cabang,
            'isEdit' => true,
            'kampus' => Kampus::orderBy('nama_kampus')->get(),
        ]);
    }

    public function update(Request $request, Cabang $cabang)
    {
        $this->authorizeSuperAdmin();

        $cabang->update($this->validateRequest($request));

        return redirect()->route('super-admin.cabang.index')
            ->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Cabang $cabang)
    {
        $this->authorizeSuperAdmin();

        $cabang->delete();

        return redirect()->route('super-admin.cabang.index')
            ->with('success', 'Cabang berhasil dihapus.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'id_kampus' => ['required', 'exists:kampus,id_kampus'],
            'nama_cabang' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:500'],
            'kontak' => ['required', 'string', 'max:100'],
        ]);
    }
}

