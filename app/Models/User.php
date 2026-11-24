<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_USER = 'user';

    /**
     * 'role' sengaja TIDAK dimasukkan supaya tidak bisa diubah lewat
     * mass assignment (mencegah privilege escalation saat register).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /** Hanya akun dengan role "user" (bukan admin). */
    public function scopeRegular(Builder $query): void
    {
        $query->where('role', self::ROLE_USER);
    }

    /** Halaman utama setelah login, tergantung role. */
    public function homeUrl(): string
    {
        return route($this->isAdmin() ? 'dashboard' : 'pemesanan.create');
    }

    /** Hanya admin yang boleh masuk ke panel Filament (/admin). */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }
}
