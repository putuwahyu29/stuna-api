<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'kelas';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_kelas'];

    protected $validationRules    = [
        'nama_kelas' => 'required|is_unique[kelas.nama_kelas]',
    ];
    protected $validationMessages = [
        'nama_kelas' => [
            'required' => 'Nama Kelas Harus Diisi',
            'is_unique' => 'Nama Kelas Sudah Ada'
        ]
    ];
}
