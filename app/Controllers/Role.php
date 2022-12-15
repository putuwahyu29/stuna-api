<?php

namespace App\Controllers;

use App\Models\RoleModel;
use CodeIgniter\RESTful\ResourceController;

class Role extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }
    public function index()
    {
        $data = $this->roleModel->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = $this->roleModel->find($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ditemukan role dengan id ' . $id);
        }
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = [
            'name' => $this->request->getVar('name'),
        ];
        if ($this->roleModel->insert($data)) {
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Data Role Berhasil Ditambahkan'
                ]
            ];
        } else {
            $response = [
                'status' => 500,
                'error' => null,
                'messages' => [
                    'error' => $this->roleModel->errors()
                ]
            ];
        }
        return $this->respond($response);
    }



    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = [
            'name' => $this->request->getVar('name'),
        ];
        if ($this->roleModel->update($id, $data)) {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data Role Berhasil Diubah'
                ]
            ];
        } else {
            $response = [
                'status' => 500,
                'error' => null,
                'messages' => [
                    'error' => $this->roleModel->errors()
                ]
            ];
        }
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        if ($this->roleModel->delete($id)) {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data Role Berhasil Dihapus'
                ]
            ];
        } else {
            $response = [
                'status' => 500,
                'error' => null,
                'messages' => [
                    'error' => $this->roleModel->errors()
                ]
            ];
        }
        return $this->respond($response);
    }
}
