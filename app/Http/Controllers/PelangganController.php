<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Pelanggan::class);

        $cari   = $request->input('cari', '');
        $level  = $request->input('level', '');
        $status = $request->input('status', '');

        $pelanggan = Pelanggan::query()
            ->when($cari, function ($q) use ($cari) {
                $q->where(function ($q) use ($cari) {
                    $q->where('nama', 'like', "%$cari%")
                      ->orWhere('email', 'like', "%$cari%")
                      ->orWhere('no_hp', 'like', "%$cari%");
                });
            })
            ->when($level, fn ($q) => $q->where('level_member', $level))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('id')
            ->get();

        $ringkasan = [
            'total' => Pelanggan::count(),
            'basic' => Pelanggan::where('level_member', 'basic')->count(),
            'gold'  => Pelanggan::where('level_member', 'gold')->count(),
            'vip'   => Pelanggan::where('level_member', 'vip')->count(),
            'aktif' => Pelanggan::where('status', 'aktif')->count(),
        ];

        return view('pelanggan.index', compact('pelanggan', 'cari', 'level', 'status', 'ringkasan'));
    }

    public function create()
    {
        Gate::authorize('create', Pelanggan::class);

        return view('pelanggan.form');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Pelanggan::class);

        $data = $this->validasi($request);
        $data['tanggal_bergabung'] = now()->toDateString();
        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    public function edit(Pelanggan $pelanggan)
    {
        Gate::authorize('update', $pelanggan);

        return view('pelanggan.form', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        Gate::authorize('update', $pelanggan);

        $pelanggan->update($this->validasi($request));

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diubah');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        Gate::authorize('delete', $pelanggan);

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil dihapus');
    }

    private function validasi(Request $request)
    {
        return $request->validate([
            'nama'          => 'required|string|max:100',
            'email'         => 'nullable|email|max:100',
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'level_member'  => 'required|in:basic,gold,vip',
            'status'        => 'required|in:aktif,nonaktif',
        ]);
    }
}