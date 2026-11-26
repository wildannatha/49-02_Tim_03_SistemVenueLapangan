<?php

namespace App\Policies;

use App\Models\Pemesanan;
use App\Models\User;

/**
 * Hak akses modul Pemesanan.
 *
 * | Fitur  | Admin | User  |
 * |--------|-------|-------|
 * | Lihat  |  ya   |  ya   |
 * | Tambah |  ya   |  ya   |
 * | Edit   |  ya   | tidak |
 * | Hapus  |  ya   | tidak |
 *
 * Dipakai otomatis oleh Filament (panel admin) dan oleh route
 * lewat ->can(...) di routes/web.php.
 */
class PemesananPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Pemesanan $pemesanan): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Pemesanan $pemesanan): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Pemesanan $pemesanan): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
