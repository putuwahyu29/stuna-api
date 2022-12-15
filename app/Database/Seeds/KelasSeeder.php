<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {

        $data = [
            [
                'nama_kelas' => '1D31',
            ],
            [
                'nama_kelas' => '1D32',
            ],
            [
                'nama_kelas' => '1D33',
            ],
            [
                'nama_kelas' => '1D34',
            ],
            [
                'nama_kelas' => '1D35',
            ],
            [
                'nama_kelas' => '1ST1'
            ],
            [
                'nama_kelas' => '1ST2'
            ],
            [
                'nama_kelas' => '1ST3'
            ],
            [
                'nama_kelas' => '1ST4'
            ],
            [
                'nama_kelas' => '1ST5'
            ],
            [
                'nama_kelas' => '1KS1'
            ],
            [
                'nama_kelas' => '1KS2'
            ],
            [
                'nama_kelas' => '1KS3'
            ],
            [
                'nama_kelas' => '1KS4'
            ],
            [
                'nama_kelas' => '1KS5'
            ],
            [
                'nama_kelas' => '2D31'
            ],
            [
                'nama_kelas' => '2D32'
            ],
            [
                'nama_kelas' => '2D33'
            ],
            [
                'nama_kelas' => '2D34'
            ],
            [
                'nama_kelas' => '2D35'
            ],
            [
                'nama_kelas' => '2ST1'
            ],
            [
                'nama_kelas' => '2ST2'
            ],
            [
                'nama_kelas' => '2ST3'
            ],
            [
                'nama_kelas' => '2ST4'
            ],
            [
                'nama_kelas' => '2ST5'
            ],
            [
                'nama_kelas' => '2KS1'
            ],
            [
                'nama_kelas' => '2KS2'
            ],
            [
                'nama_kelas' => '2KS3'
            ],
            [
                'nama_kelas' => '2KS4'
            ],
            [
                'nama_kelas' => '2KS5'
            ],
            [
                'nama_kelas' => '3D31'
            ],
            [
                'nama_kelas' => '3D32'
            ],
            [
                'nama_kelas' => '3D33'
            ],
            [
                'nama_kelas' => '3D34'
            ],
            [
                'nama_kelas' => '3D35'
            ],
            [
                'nama_kelas' => '3SE1'
            ],
            [
                'nama_kelas' => '3SE2'
            ],
            [
                'nama_kelas' => '3SE3'
            ],
            [
                'nama_kelas' => '3SE4'
            ],
            [
                'nama_kelas' => '3SE5'
            ],
            [
                'nama_kelas' => '3SK1'
            ],
            [
                'nama_kelas' => '3SK2'
            ],
            [
                'nama_kelas' => '3SK3'
            ],
            [
                'nama_kelas' => '3SK4'
            ],
            [
                'nama_kelas' => '3SK5'
            ],
            [
                'nama_kelas' => '3SD1'
            ],
            [
                'nama_kelas' => '3SD2'
            ],
            [
                'nama_kelas' => '3SI1'
            ],
            [
                'nama_kelas' => '3SI2'
            ],
            [
                'nama_kelas' => '3SI3'
            ],
            [
                'nama_kelas' => '4SE1'
            ],
            [
                'nama_kelas' => '4SE2'
            ],
            [
                'nama_kelas' => '4SE3'
            ],
            [
                'nama_kelas' => '4SE4'
            ],
            [
                'nama_kelas' => '4SK1'
            ],
            [
                'nama_kelas' => '4SK2'
            ],
            [
                'nama_kelas' => '4SK3'
            ],
            [
                'nama_kelas' => '4SK4'
            ],
            [
                'nama_kelas' => '4SD1'
            ],
            [
                'nama_kelas' => '4SD2'
            ],
            [
                'nama_kelas' => '4SI1'
            ],
            [
                'nama_kelas' => '4SI2'
            ],
            [
                'nama_kelas' => '4SI3'
            ]
        ];
        $this->db->table('kelas')->insertBatch($data);
    }
}
