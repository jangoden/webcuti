<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed leave types
        $this->call(LeaveTypeSeeder::class);

        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@webcuti.com',
            'password' => bcrypt('password'),
            'nip' => '000000000000000000',
            'jabatan' => 'Administrator Sistem',
            'jenis_pegawai' => 'ASN',
            'username' => 'admin',
            'jumlah_cuti' => 12,
            'role' => 'admin',
        ]);

        // Create sample employee
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@webcuti.com',
            'password' => bcrypt('password'),
            'nip' => '199001012020011001',
            'jabatan' => 'Staff Administrasi',
            'jenis_pegawai' => 'ASN',
            'username' => 'budi',
            'jumlah_cuti' => 12,
            'role' => 'pegawai',
        ]);

        // Create another sample employee
        User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@webcuti.com',
            'password' => bcrypt('password'),
            'nip' => '199205152021012001',
            'jabatan' => 'Analis Kepegawaian',
            'jenis_pegawai' => 'PPPK',
            'username' => 'siti',
            'jumlah_cuti' => 12,
            'role' => 'pegawai',
        ]);
    }
}
