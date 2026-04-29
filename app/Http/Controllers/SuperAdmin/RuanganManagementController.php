<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganManagementController extends Controller
{
    private function authorizeSuperAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403, 'Akses hanya untuk super admin.');
    }

    public function index()
    {
        $this->authorizeSuperAdmin();

        $ruangan = Ruangan::with(['gedung.fakultas', 'gedung.cabang'])
            ->latest('id_ruangan')
            ->paginate(15);

        return view('super-admin.ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.ruangan.form', [
            'item' => new Ruangan(),
            'gedungs' => Gedung::with(['fakultas', 'cabang'])->orderBy('nama_gedung')->get(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        Ruangan::create($this->validateRequest($request));

        return redirect()->route('super-admin.ruangan.index')
            ->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan)
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.ruangan.form', [
            'item' => $ruangan,
            'gedungs' => Gedung::with(['fakultas', 'cabang'])->orderBy('nama_gedung')->get(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $this->authorizeSuperAdmin();

        $ruangan->update($this->validateRequest($request));

        return redirect()->route('super-admin.ruangan.index')
            ->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $this->authorizeSuperAdmin();

        $ruangan->delete();

        return redirect()->route('super-admin.ruangan.index')
            ->with('success', 'Data ruangan berhasil dihapus.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'id_gedung' => ['required', 'exists:gedung,id_gedung'],
            'nomor_ruangan' => ['required', 'string', 'max:50'],
            'nama_ruangan' => ['required', 'string', 'max:255'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'fasilitas' => ['required', 'string'],
            'lantai' => ['required', 'integer', 'min:0'],
            'tipe_ruangan' => ['required', 'string', 'max:100'],
        ]);
    }
}
