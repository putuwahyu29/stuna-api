<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['username', 'fullName', 'email', 'nama_panggilan', 'alamat', 'no_hp', 'foto', 'nim', 'kelas_id'];

    public function findUserByUserName(string $username)
    {
        $user = $this
            ->asArray()
            ->where(['username' => $username])
            ->first();
        return $user;
    }
}
