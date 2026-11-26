<?php

namespace App\Policies;

use App\Models\Pelanggan;
use App\Models\User;

class PelangganPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff', 'member']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    public function update(User $user, Pelanggan $pelanggan): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    public function delete(User $user, Pelanggan $pelanggan): bool
    {
        return $user->role === 'admin';
    }
}
