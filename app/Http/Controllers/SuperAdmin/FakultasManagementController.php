<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Fakultas;
use Illuminate\Http\Request;

class FakultasManagementController extends Controller
{
    private function authorizeSuperAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403, 'Akses hanya untuk super admin.');
    }

    public function index()
    {
        $this->authorizeSuperAdmin();

        $fakultas = Fakultas::with('cabang')
            ->orderByDesc('id_fakultas')
            ->paginate(15);

        return view('super-admin.fakultas.index', compact('fakultas'));
    }

    public function create()
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.fakultas.form', [
            'item' => new Fakultas(),
            'isEdit' => false,
            'cabangs' => Cabang::with('kampus')->orderBy('nama_cabang')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        Fakultas::create($this->validateRequest($request));

        return redirect()->route('super-admin.fakultas.index')
            ->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Fakultas $fakultas)
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.fakultas.form', [
            'item' => $fakultas,
            'isEdit' => true,
            'cabangs' => Cabang::with('kampus')->orderBy('nama_cabang')->get(),
        ]);
    }

    public function update(Request $request, Fakultas $fakultas)
    {
        $this->authorizeSuperAdmin();

        $fakultas->update($this->validateRequest($request));

        return redirect()->route('super-admin.fakultas.index')
            ->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function destroy(Fakultas $fakultas)
    {
        $this->authorizeSuperAdmin();

        $fakultas->delete();

        return redirect()->route('super-admin.fakultas.index')
            ->with('success', 'Fakultas berhasil dihapus.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'id_cabang' => ['required', 'exists:cabang,id_cabang'],
            'nama_fakultas' => ['required', 'string', 'max:255'],
        ]);
    }
}

