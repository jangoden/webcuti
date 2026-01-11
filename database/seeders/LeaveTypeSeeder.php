<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = [
            [
                'name' => 'Cuti Tahunan',
                'description' => 'Cuti tahunan yang diberikan kepada pegawai sesuai dengan ketentuan yang berlaku.',
                'requires_attachment' => false,
            ],
            [
                'name' => 'Cuti Besar',
                'description' => 'Cuti yang diberikan kepada pegawai yang telah bekerja sekurang-kurangnya 6 tahun secara terus menerus.',
                'requires_attachment' => false,
            ],
            [
                'name' => 'Cuti Sakit',
                'description' => 'Cuti yang diberikan kepada pegawai yang sakit dengan melampirkan surat keterangan dokter.',
                'requires_attachment' => true,
            ],
            [
                'name' => 'Cuti Melahirkan',
                'description' => 'Cuti yang diberikan kepada pegawai wanita yang akan melahirkan.',
                'requires_attachment' => true,
            ],
            [
                'name' => 'Cuti Alasan Penting',
                'description' => 'Cuti yang diberikan karena alasan penting seperti pernikahan, kematian keluarga, dll.',
                'requires_attachment' => true,
            ],
            [
                'name' => 'Cuti Kampanye',
                'description' => 'Cuti yang diberikan kepada pegawai yang akan melakukan kampanye dalam pemilihan umum.',
                'requires_attachment' => true,
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::create($leaveType);
        }
    }
}
