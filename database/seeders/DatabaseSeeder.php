<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('areas')->count() == 0) {
            DB::table('areas')->insert([
                ['id' => 1, 'nama_area' => 'Gedung A', 'tipe' => 'indoor', 'deskripsi' => 'Gedung olahraga tertutup'],
                ['id' => 2, 'nama_area' => 'Lapangan Terbuka', 'tipe' => 'outdoor', 'deskripsi' => 'Area luar ruangan'],
            ]);

            DB::table('lapangans')->insert([
                [
                    'id' => 1,
                    'area_id' => 1,
                    'kode' => 'BDM-01',
                    'nama_lapangan' => 'Badminton 1',
                    'cabang_olahraga' => 'Badminton',
                    'jenis_permukaan' => 'vinyl',
                    'panjang' => 13.4,
                    'lebar' => 6.1,
                    'status_fisik' => 'baik',
                    'keterangan' => null,
                ],
                [
                    'id' => 2,
                    'area_id' => 2,
                    'kode' => 'FTS-01',
                    'nama_lapangan' => 'Futsal 1',
                    'cabang_olahraga' => 'Futsal',
                    'jenis_permukaan' => 'rumput_sintetis',
                    'panjang' => 25,
                    'lebar' => 15,
                    'status_fisik' => 'perlu_perbaikan',
                    'keterangan' => null,
                ],
            ]);
        }

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Venue',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@gmail.com'],
            [
                'name' => 'Staff Venue',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
            ]
        );

        User::updateOrCreate(
            ['email' => 'member@gmail.com'],
            [
                'name' => 'Member Venue',
                'password' => Hash::make('member123'),
                'role' => 'member',
            ]
        );

        $contoh = [
            ['nama' => 'Budi Santoso', 'email' => 'budi@mail.test', 'no_hp' => '081111111111', 'level_member' => 'gold',  'status' => 'aktif'],
            ['nama' => 'Citra Dewi',   'email' => 'citra@mail.test', 'no_hp' => '082222222222', 'level_member' => 'vip',   'status' => 'aktif'],
            ['nama' => 'Dimas Pratama','email' => 'dimas@mail.test', 'no_hp' => '083333333333', 'level_member' => 'basic', 'status' => 'nonaktif'],
        ];

        foreach ($contoh as $data) {
            Pelanggan::firstOrCreate(
                ['nama' => $data['nama']],
                $data + ['tanggal_bergabung' => now()->toDateString()]
            );
        }
    }
}
