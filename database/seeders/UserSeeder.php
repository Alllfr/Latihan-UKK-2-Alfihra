<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'        => 'Administrator',
            'email'       => 'admin@perpustakaan.sch.id',
            'nis'         => null,
            'kelas'       => null,
            'role'        => 'admin',
            'status_akun' => 'Aktif',
            'password'    => Hash::make('admin123'),
        ]);

        User::create([
            'name'        => 'Budi Santoso',
            'email'       => null,
            'nis'         => '2024001',
            'kelas'       => 'XII RPL 1',
            'role'        => 'siswa',
            'status_akun' => 'Aktif',
            'password'    => Hash::make('20050115'),
        ]);
    }
}