<?php

namespace App\Http\Controllers;

use App\Http\Requests\PemesananRequest;
use App\Models\Pemesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * CRUD pemesanan untuk sisi user/admin (non-Filament).
 * Hak akses per aksi diatur di routes/web.php lewat ->can(...).
 */
class PemesananController extends Controller
{
    public function index(): View
    {
        return view('pemesanan.index', [
            'pemesanans' => Pemesanan::latest('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('pemesanan.form', ['pemesanan' => new Pemesanan]);
    }

    public function store(PemesananRequest $request): RedirectResponse
    {
        Pemesanan::create($request->validated());

        return to_route('pemesanan.index')
            ->with('status', 'Pemesanan berhasil ditambahkan.');
    }

    public function edit(Pemesanan $pemesanan): View
    {
        return view('pemesanan.form', compact('pemesanan'));
    }

    public function update(PemesananRequest $request, Pemesanan $pemesanan): RedirectResponse
    {
        $pemesanan->update($request->validated());

        return to_route('pemesanan.index')
            ->with('status', 'Pemesanan berhasil diperbarui.');
    }

    public function destroy(Pemesanan $pemesanan): RedirectResponse
    {
        $pemesanan->delete();

        return to_route('pemesanan.index')
            ->with('status', 'Pemesanan berhasil dihapus.');
    }
}
