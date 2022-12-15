<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name'];

    // Validation
    protected $validationRules      = [
        'name' => 'required|is_unique[roles.name]',
    ];
    protected $validationMessages   = [
        'name' => [
            'required' => 'Role Name Harus Diisi',
            'is_unique' => 'Role Name Sudah Ada'
        ]
    ];
}
