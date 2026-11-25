<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // 1. Insert Users (Password: password123)
        

        // 5. Insert Riwayat Status Awal
        $riwayat = [
            [
                'id_tugas'    => 1,
                'id_user'     => 1,
                'status_lama' => null,
                'status_baru' => 'belum',
            ],
            [
                'id_tugas'    => 1,
                'id_user'     => 2,
                'status_lama' => 'belum',
                'status_baru' => 'proses',
            ],
        ];
        $this->db->table('riwayat_status')->insertBatch($riwayat);
    }
}