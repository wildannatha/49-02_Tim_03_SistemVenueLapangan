<?php

use App\Models\Pemesanan;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->user = User::factory()->create();

    $this->pemesanan = Pemesanan::factory()->create(['nama' => 'Budi', 'raket' => 1]);

    $this->payload = [
        'nama' => 'Siti',
        'tanggal' => '2026-11-02',
        'jam' => '11:00',
        'raket' => 1,
        'sepatu' => 0,
        'bola' => 0,
    ];
});

// ---------- Tamu ----------

it('mengarahkan tamu ke halaman login', function () {
    $this->get('/pemesanan-user')->assertRedirect('/login');
    $this->get('/pemesanan-user/data')->assertRedirect('/login');
    $this->post('/pemesanan-user', $this->payload)->assertRedirect('/login');
    $this->get('/dashboard')->assertRedirect('/login');
});

it('mengarahkan tamu yang buka panel admin ke login', function () {
    $this->get('/admin')->assertRedirect('/login');
});

// ---------- User biasa ----------

it('mengizinkan user melihat dan menambah pemesanan', function () {
    $this->actingAs($this->user)->get('/pemesanan-user')->assertOk();
    $this->actingAs($this->user)->get('/pemesanan-user/data')->assertOk();

    $this->actingAs($this->user)
        ->post('/pemesanan-user', $this->payload)
        ->assertRedirect('/pemesanan-user/data');

    expect(Pemesanan::where('nama', 'Siti')->exists())->toBeTrue();
});

it('melarang user mengedit pemesanan', function () {
    $this->actingAs($this->user)
        ->get("/pemesanan-user/{$this->pemesanan->id}/edit")
        ->assertForbidden();

    $this->actingAs($this->user)
        ->put("/pemesanan-user/{$this->pemesanan->id}", $this->payload)
        ->assertForbidden();

    expect($this->pemesanan->fresh()->nama)->toBe('Budi');
});

it('melarang user menghapus pemesanan', function () {
    $this->actingAs($this->user)
        ->delete("/pemesanan-user/{$this->pemesanan->id}")
        ->assertForbidden();

    expect(Pemesanan::find($this->pemesanan->id))->not->toBeNull();
});

it('menyembunyikan tombol edit dan hapus dari user', function () {
    $this->actingAs($this->user)
        ->get('/pemesanan-user/data')
        ->assertOk()
        ->assertSee('Budi')
        ->assertDontSee('Hapus')
        ->assertDontSee('/edit');
});

it('melarang user masuk ke panel admin dan dashboard', function () {
    expect($this->user->canAccessPanel(Filament::getPanel('admin')))->toBeFalse();

    $this->actingAs($this->user)->get('/admin')->assertForbidden();
    $this->actingAs($this->user)->get('/dashboard')->assertForbidden();
});

// ---------- Admin ----------

it('mengizinkan admin melakukan semua aksi pemesanan', function () {
    $this->actingAs($this->admin)
        ->get("/pemesanan-user/{$this->pemesanan->id}/edit")
        ->assertOk();

    $this->actingAs($this->admin)
        ->put("/pemesanan-user/{$this->pemesanan->id}", $this->payload)
        ->assertRedirect('/pemesanan-user/data');

    expect($this->pemesanan->fresh()->nama)->toBe('Siti');

    $this->actingAs($this->admin)
        ->delete("/pemesanan-user/{$this->pemesanan->id}")
        ->assertRedirect('/pemesanan-user/data');

    expect(Pemesanan::find($this->pemesanan->id))->toBeNull();
});

it('menampilkan tombol edit dan hapus untuk admin', function () {
    $this->actingAs($this->admin)
        ->get('/pemesanan-user/data')
        ->assertSee('Hapus')
        ->assertSee("/pemesanan-user/{$this->pemesanan->id}/edit");
});

it('mengizinkan admin masuk ke panel admin dan dashboard', function () {
    expect($this->admin->canAccessPanel(Filament::getPanel('admin')))->toBeTrue();

    $this->actingAs($this->admin)->get('/dashboard')->assertOk()->assertSee('Dashboard Admin');
    $this->actingAs($this->admin)->get('/admin')->assertOk();
});

// ---------- Validasi & perhitungan ----------

it('menghitung total bayar otomatis', function () {
    $this->actingAs($this->user)->post('/pemesanan-user', [
        ...$this->payload, 'raket' => 2, 'sepatu' => 1, 'bola' => 1,
    ]);

    expect(Pemesanan::where('nama', 'Siti')->first()->total_bayar)
        ->toBe(4 * Pemesanan::HARGA_PER_ALAT);
});

it('menganggap jumlah alat yang kosong sebagai 0', function () {
    $this->actingAs($this->user)
        ->post('/pemesanan-user', [...$this->payload, 'raket' => '', 'sepatu' => null, 'bola' => '']);

    $pemesanan = Pemesanan::where('nama', 'Siti')->first();

    expect($pemesanan->raket)->toBe(0)
        ->and($pemesanan->total_bayar)->toBe(0);
});

it('menolak input pemesanan yang tidak valid', function () {
    $this->actingAs($this->user)
        ->post('/pemesanan-user', [...$this->payload, 'nama' => '', 'raket' => -1])
        ->assertSessionHasErrors(['nama', 'raket']);

    expect(Pemesanan::count())->toBe(1);
});

it('tidak membiarkan total_bayar diisi dari luar', function () {
    $this->actingAs($this->user)
        ->post('/pemesanan-user', [...$this->payload, 'total_bayar' => 1]);

    expect(Pemesanan::where('nama', 'Siti')->first()->total_bayar)
        ->toBe(Pemesanan::HARGA_PER_ALAT);
});

// ---------- Login & register ----------

it('mengarahkan login sesuai role', function () {
    $this->post('/login', ['email' => $this->admin->email, 'password' => 'password'])
        ->assertRedirect('/dashboard');

    auth()->logout();

    $this->post('/login', ['email' => $this->user->email, 'password' => 'password'])
        ->assertRedirect('/pemesanan-user');
});

it('menolak login dengan password salah', function () {
    $this->post('/login', ['email' => $this->user->email, 'password' => 'salah'])
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('mengarahkan user yang sudah login dari halaman login ke halamannya', function () {
    $this->actingAs($this->admin)->get('/login')->assertRedirect('/dashboard');
    $this->actingAs($this->user)->get('/login')->assertRedirect('/pemesanan-user');
});

it('selalu membuat akun register sebagai user biasa', function () {
    $this->post('/register', [
        'name' => 'Hacker',
        'email' => 'hacker@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'admin', // coba menyusup, harus diabaikan
    ])->assertRedirect('/pemesanan-user');

    expect(User::where('email', 'hacker@example.com')->first()->role)->toBe(User::ROLE_USER);
});

it('bisa logout', function () {
    $this->actingAs($this->user)->post('/logout')->assertRedirect('/login');

    $this->assertGuest();
});

// ---------- Panel admin (Filament) ----------

it('menampilkan halaman data & tambah pemesanan di panel admin untuk admin', function () {
    $this->actingAs($this->admin)->get('/admin/pemesanans')->assertOk()->assertSee('Budi');
    $this->actingAs($this->admin)->get('/admin/pemesanans/create')->assertOk();
    $this->actingAs($this->admin)->get("/admin/pemesanans/{$this->pemesanan->id}/edit")->assertOk();
});
