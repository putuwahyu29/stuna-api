<?php

namespace App\Controllers;

use App\Models\KelasModel;
use CodeIgniter\RESTful\ResourceController;

class Kelas extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
    }
    public function index()
    {
        $data = $this->kelasModel->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = $this->kelasModel->find($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ditemukan kelas dengan id ' . $id);
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
            'nama_kelas' => $this->request->getVar('nama_kelas'),
        ];
        if ($this->kelasModel->insert($data)) {
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Data Kelas Berhasil Ditambahkan'
                ]
            ];
            return $this->respondCreated($response, 201);
        } else {
            $response = [
                'status' => 500,
                'error' => null,
                'messages' => [
                    'error' => $this->kelasModel->errors()
                ]
            ];
            return $this->respondCreated($response, 500);
        }
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = $this->kelasModel->find($id);
        if ($data) {
            $input = [
                'id' => $id,
                'nama_kelas' => $this->request->getVar('nama_kelas'),
            ];
            if ($this->kelasModel->update($id, $input)) {
                $response = [
                    'status' => 200,
                    'error' => null,
                    'messages' => [
                        'success' => 'Data Kelas Berhasil Diubah'
                    ]
                ];
            } else {
                $response = [
                    'status' => 400,
                    'error' => null,
                    'messages' => [
                        'error' => $this->kelasModel->errors()
                    ]
                ];
            }
            return $this->respond($response);
        } else {
            return $this->failNotFound('Tidak ditemukan kelas dengan id ' . $id);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $data = $this->kelasModel->find($id);
        if ($data) {
            $this->kelasModel->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data Kelas Berhasil Dihapus'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }
}
