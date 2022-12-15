<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengumuman';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['judul', 'isi', 'slug', 'gambar', 'user_id', 'kelas_id', 'excerpt', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function findPengumumanBySlug($slug)
    {
        return $this->where(['slug' => $slug])->first();
    }
}
