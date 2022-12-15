<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreModel extends Model
{
    protected $table            = '';
    protected $primaryKey       = '';



    public function getAllAdmin()
    {
        $builder = $this->db->table('auth');
        $builder->select('auth.username, user.fullName, user.email,user.kelas_id,user.id,kelas.nama_kelas');
        $builder->join('user', 'auth.username = user.username');
        $builder->join('kelas', 'user.kelas_id = kelas.id');
        $builder->where('auth.role_id', 2);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getAllUser()
    {
        $builder = $this->db->table('auth');
        $builder->select('auth.username, user.fullName, user.email,user.kelas_id,user.id,kelas.nama_kelas');
        $builder->join('user', 'auth.username = user.username');
        $builder->join('kelas', 'user.kelas_id = kelas.id');
        $builder->where('auth.role_id', 3);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function setRoleToAdmin($username)
    {
        $builder = $this->db->table('auth');
        $builder->set('role_id', 2);
        $builder->where('username', $username);
        $builder->update();
    }

    public function deleteRoleAdmin($username)
    {
        $builder = $this->db->table('auth');
        $builder->set('role_id', 3);
        $builder->where('username', $username);
        $builder->update();
    }

    public function getPengumumanByKelasId($id)
    {
        $builder = $this->db->table('pengumuman');
        $builder->select('pengumuman.id, pengumuman.judul, pengumuman.isi, pengumuman.created_at, pengumuman.updated_at, pengumuman.kelas_id, pengumuman.user_id, user.fullName, pengumuman.slug,pengumuman.excerpt, pengumuman.gambar');
        $builder->join('user', 'pengumuman.user_id = user.id');
        $builder->where('pengumuman.kelas_id', $id);
        $builder->orderBy('pengumuman.updated_at', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getPengumumanByKelasIdLimit($id)
    {
        $builder = $this->db->table('pengumuman');
        $builder->select('pengumuman.id, pengumuman.judul, pengumuman.isi, pengumuman.created_at, pengumuman.updated_at, pengumuman.kelas_id, pengumuman.user_id, user.fullName, pengumuman.slug,pengumuman.excerpt, pengumuman.gambar');
        $builder->join('user', 'pengumuman.user_id = user.id');
        $builder->where('pengumuman.kelas_id', $id);
        $builder->orderBy('pengumuman.updated_at', 'DESC');
        $builder->limit(9);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getPengumumanTerbaru($id)
    {
        $builder = $this->db->table('pengumuman');
        $builder->select('pengumuman.id, pengumuman.judul, pengumuman.isi, pengumuman.created_at, pengumuman.updated_at, pengumuman.kelas_id, pengumuman.user_id, user.fullName, pengumuman.slug,pengumuman.excerpt, pengumuman.gambar');
        $builder->join('user', 'pengumuman.user_id = user.id');
        $builder->where('pengumuman.kelas_id', $id);
        $builder->orderBy('pengumuman.updated_at', 'DESC');
        $builder->limit(1);
        $query = $builder->get();
        return $query->getRow();
    }

    public function getUserByKelasId($id)
    {
        $builder = $this->db->table('user');
        $builder->where('kelas_id', $id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function deleteKelasUser($username)
    {
        $builder = $this->db->table('user');
        $builder->set('kelas_id', null);
        $builder->where('username', $username);
        $builder->update();
    }
}
