<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kampus;
use Illuminate\Http\Request;

class KampusManagementController extends Controller
{
    private function authorizeSuperAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403, 'Akses hanya untuk super admin.');
    }

    public function index()
    {
        $this->authorizeSuperAdmin();

        $kampus = Kampus::query()
            ->orderByDesc('id_kampus')
            ->paginate(15);

        return view('super-admin.kampus.index', compact('kampus'));
    }

    public function create()
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.kampus.form', [
            'item' => new Kampus(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        Kampus::create($request->validate([
            'nama_kampus' => ['required', 'string', 'max:255'],
        ]));

        return redirect()->route('super-admin.kampus.index')
            ->with('success', 'Kampus berhasil ditambahkan.');
    }

    public function edit(Kampus $kampus)
    {
        $this->authorizeSuperAdmin();

        return view('super-admin.kampus.form', [
            'item' => $kampus,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Kampus $kampus)
    {
        $this->authorizeSuperAdmin();

        $kampus->update($request->validate([
            'nama_kampus' => ['required', 'string', 'max:255'],
        ]));

        return redirect()->route('super-admin.kampus.index')
            ->with('success', 'Kampus berhasil diperbarui.');
    }

    public function destroy(Kampus $kampus)
    {
        $this->authorizeSuperAdmin();

        $kampus->delete();

        return redirect()->route('super-admin.kampus.index')
            ->with('success', 'Kampus berhasil dihapus.');
    }
}

