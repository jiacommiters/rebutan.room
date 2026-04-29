<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Gedung;
use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GedungManagementController extends Controller
{
    private function authorizeSuperAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403, 'Akses hanya untuk super admin.');
    }

    public function index()
    {
        $this->authorizeSuperAdmin();

        $gedung = Gedung::with(['cabang', 'fakultas'])
            ->orderByDesc('id_gedung')
            ->paginate(15);

        return view('super-admin.gedung.index', compact('gedung'));
    }

    public function create()
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.gedung.form', [
            'item' => new Gedung(),
            'isEdit' => false,
            'cabangs' => Cabang::with('kampus')->orderBy('nama_cabang')->get(),
            'fakultas' => Fakultas::with('cabang.kampus')->orderBy('nama_fakultas')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        Gedung::create($this->validateRequest($request));

        return redirect()->route('super-admin.gedung.index')
            ->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function edit(Gedung $gedung)
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.gedung.form', [
            'item' => $gedung,
            'isEdit' => true,
            'cabangs' => Cabang::with('kampus')->orderBy('nama_cabang')->get(),
            'fakultas' => Fakultas::with('cabang.kampus')->orderBy('nama_fakultas')->get(),
        ]);
    }

    public function update(Request $request, Gedung $gedung)
    {
        $this->authorizeSuperAdmin();

        $gedung->update($this->validateRequest($request));

        return redirect()->route('super-admin.gedung.index')
            ->with('success', 'Gedung berhasil diperbarui.');
    }

    public function destroy(Gedung $gedung)
    {
        $this->authorizeSuperAdmin();

        $gedung->delete();

        return redirect()->route('super-admin.gedung.index')
            ->with('success', 'Gedung berhasil dihapus.');
    }

    private function validateRequest(Request $request): array
    {
        $kategori = $request->input('kategori');

        $rules = [
            'id_cabang' => ['required', 'exists:cabang,id_cabang'],
            'kode_gedung' => ['required', 'string', 'max:50'],
            'nama_gedung' => ['required', 'string', 'max:255'],
            'jumlah_lantai' => ['required', 'integer', 'min:0'],
            'kategori' => ['required', 'in:umum,fakultas'],
            'id_fakultas' => ['nullable', 'exists:fakultas,id_fakultas'],
        ];

        // Business rule: kategori fakultas -> id_fakultas wajib
        if ($kategori === 'fakultas') {
            $rules['id_fakultas'] = ['required', 'exists:fakultas,id_fakultas'];
        }

        // Business rule: kategori umum -> id_fakultas boleh kosong
        if ($kategori === 'umum') {
            $request->merge(['id_fakultas' => null]);
        }

        $data = $request->validate($rules);

        // Business rule: gedung kategori fakultas harus berada pada cabang yang sama dengan fakultasnya.
        if ($data['kategori'] === 'fakultas' && !empty($data['id_fakultas'])) {
            $fakultas = Fakultas::findOrFail($data['id_fakultas']);
            if ((int) $fakultas->id_cabang !== (int) $data['id_cabang']) {
                throw ValidationException::withMessages([
                    'id_fakultas' => 'id_fakultas harus berasal dari cabang yang sama dengan id_cabang.',
                ]);
            }
        }

        return $data;
    }
}

