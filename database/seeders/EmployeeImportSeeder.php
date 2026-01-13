<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeImportSeeder extends Seeder
{
    public function run(): void
    {
        // Data pegawai dari CSV
        $employees = [
            ['jabatan' => 'KEPALA SEKRETARIAT', 'nama' => 'WIDODO WURYANTO', 'nip' => '197012041990091001', 'jenis' => 'ASN'],
            ['jabatan' => 'KEPALA BAGIAN HUKUM, HUBUNGAN MASYARAKAT, DATA, DAN INFORMASI', 'nama' => 'ISTI KHORIANA KARIM', 'nip' => '197904292003122001', 'jenis' => 'ASN'],
            ['jabatan' => 'KEPALA BAGIAN ADMINISTRASI', 'nama' => 'MUHAMAD ZARWAN', 'nip' => '197908152014031001', 'jenis' => 'ASN'],
            ['jabatan' => 'KEPALA BAGIAN PENANGANAN PELANGGARAN DAN PENYELESAIAN SENGKETA PROSES PEMILU', 'nama' => 'NURUL PARAMITA', 'nip' => '197708221996122001', 'jenis' => 'ASN'],
            ['jabatan' => 'KEPALA BAGIAN PENGAWASAN PEMILU', 'nama' => 'RAHMAT JAYA PARLINDUNGAN SIREGAR', 'nip' => '197507292005011003', 'jenis' => 'ASN'],
            ['jabatan' => 'PRANATA KOMPUTER TERAMPIL', 'nama' => 'ABDUL HADI', 'nip' => '197103282023211005', 'jenis' => 'PPPK'],
            ['jabatan' => 'ARSIPARIS AHLI PERTAMA', 'nama' => 'ADE WIJAYA', 'nip' => '198009122025211025', 'jenis' => 'PPPK'],
            ['jabatan' => 'PRANATA KOMPUTER TERAMPIL', 'nama' => 'DEDEN FAHAD SULTAN', 'nip' => '198112162023211004', 'jenis' => 'PPPK'],
            ['jabatan' => 'PENGELOLA PENGADAAN BARANG/JASA AHLI PERTAMA', 'nama' => 'ESTER NADYA MANALU', 'nip' => '199704272022032002', 'jenis' => 'ASN'],
            ['jabatan' => 'ANALIS PENGELOLAAN KEUANGAN APBN AHLI MUDA', 'nama' => 'HERDI SULAEMAN', 'nip' => '198402052015031002', 'jenis' => 'ASN'],
            ['jabatan' => 'PENGELOLA PENGADAAN BARANG/JASA AHLI MUDA', 'nama' => 'IRNA SEPTIANA DEVI', 'nip' => '198709092014032002', 'jenis' => 'ASN'],
            ['jabatan' => 'ARSIPARIS AHLI PERTAMA', 'nama' => 'RAHADIAN FAJAR', 'nip' => '199410092023211029', 'jenis' => 'PPPK'],
            ['jabatan' => 'ANALIS PENGELOLAAN KEUANGAN APBN AHLI PERTAMA', 'nama' => 'RATU OKTARINA TRIASTUTY', 'nip' => '198910012025052002', 'jenis' => 'CPNS'],
            ['jabatan' => 'ANALIS PENGELOLAAN KEUANGAN APBN AHLI PERTAMA', 'nama' => 'RISKA RINDHYANTIKA', 'nip' => '199109072019022001', 'jenis' => 'ASN'],
            ['jabatan' => 'PRANATA KEUANGAN APBN TERAMPIL', 'nama' => 'SYAHLA AZLIA WINATA', 'nip' => '200104122022012001', 'jenis' => 'ASN'],
            ['jabatan' => 'ANALIS SUMBER DAYA MANUSIA APARATUR AHLI PERTAMA', 'nama' => 'SYAMSUL IRFAN', 'nip' => '199308042019021001', 'jenis' => 'ASN'],
            ['jabatan' => 'PRANATA KEUANGAN APBN TERAMPIL', 'nama' => 'YANA ALYA RAHMAWATI', 'nip' => '200005162022012002', 'jenis' => 'ASN'],
            ['jabatan' => 'ANALIS SUMBER DAYA MANUSIA APARATUR AHLI PERTAMA', 'nama' => 'YOFFAN IBNOE RAMADHAN', 'nip' => '199103272020121003', 'jenis' => 'ASN'],
            ['jabatan' => 'PENGADMINISTRASI KEUANGAN', 'nama' => 'KIKI MULYANA', 'nip' => '198907172015031003', 'jenis' => 'ASN'],
            ['jabatan' => 'ANALIS PERENCANAAN ANGGARAN', 'nama' => 'MELLISA LASTIUR SIAHAAN', 'nip' => '199404142020122008', 'jenis' => 'ASN'],
            ['jabatan' => 'ANALIS BARANG MILIK NEGARA', 'nama' => 'MIA PUSPITA SARI', 'nip' => '199407212020122005', 'jenis' => 'ASN'],
            ['jabatan' => 'PENGADMINISTRASI PERKANTORAN', 'nama' => 'NENDI RUSTANDI', 'nip' => '198202042025211017', 'jenis' => 'PPPK'],
            ['jabatan' => 'PENGADMINISTRASI PERKANTORAN', 'nama' => 'PAJAR TAUFIK', 'nip' => '198512152025211023', 'jenis' => 'PPPK'],
            ['jabatan' => 'ANALIS KEUANGAN', 'nama' => 'RIZAL FADILAH MUHANAFIAH', 'nip' => '199309292019021001', 'jenis' => 'ASN'],
            ['jabatan' => 'PENGEMUDI', 'nama' => 'BOBY MAULANA SIDIQ DYAN WIJAYA', 'nip' => '12345678910', 'jenis' => 'PPNPN'], // Menggunakan PPNPN sebagai NON ASN
            ['jabatan' => 'ARSIPARIS AHLI PERTAMA', 'nama' => 'DIAN HARTINAH RACHMAN', 'nip' => '199605082024212044', 'jenis' => 'PPPK'],
            ['jabatan' => 'PERENCANA AHLI PERTAMA', 'nama' => 'M RIZQI KUSUMAH N', 'nip' => '199007032024211033', 'jenis' => 'PPPK'],
            ['jabatan' => 'PRANATA HUBUNGAN MASYARAKAT AHLI MUDA', 'nama' => 'ANDHIKA PRATAMA', 'nip' => '198611212014031001', 'jenis' => 'ASN'],
            ['jabatan' => 'PENATA KELOLA PENGAWASAN PEMILIHAN UMUM AHLI PERTAMA', 'nama' => 'BILLY ADAM FISHER', 'nip' => '199006222024211018', 'jenis' => 'PPPK'],
            ['jabatan' => 'ANALIS KEBIJAKAN AHLI PERTAMA', 'nama' => 'IRFAN PATUROHMAN', 'nip' => '199202262025211021', 'jenis' => 'PPPK'],
            ['jabatan' => 'PRANATA HUBUNGAN MASYARAKAT AHLI PERTAMA', 'nama' => 'JIHAD KHUFAYA', 'nip' => '199503172025211029', 'jenis' => 'PPPK'],
        ];

        foreach ($employees as $emp) {
            // Normalisasi Jenis Pegawai ke Enum/Convention database
            $jenisPegawai = match(true) {
                str_contains($emp['jenis'], 'PNS') || str_contains($emp['jenis'], 'ASN') => 'ASN',
                str_contains($emp['jenis'], 'PPPK') => 'PPPK',
                default => 'NON ASN',
            };

            // Generate email dummy dari nama (lowercase, hapus spasi, + @webcuti.com)
            $email = strtolower(str_replace([' ', ',', '.'], '', $emp['nama'])) . '@webcuti.com';
            
            // Bersihkan nama dari spasi ganda
            $cleanName = trim(preg_replace('/\s+/', ' ', $emp['nama']));

            User::updateOrCreate(
                ['nip' => $emp['nip']], // Kunci pencarian (agar tidak duplikat)
                [
                    'name' => $cleanName,
                    'email' => $email,
                    'password' => Hash::make('password'), // Password default
                    'role' => 'pegawai',
                    'jabatan' => $emp['jabatan'],
                    'jenis_pegawai' => $jenisPegawai,
                    'jumlah_cuti' => 12, // Default cuti tahunan
                    'username' => $emp['nip'], // Username pakai NIP
                ]
            );
        }
    }
}
