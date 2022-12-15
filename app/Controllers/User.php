<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->authModel = new AuthModel();
    }
    use ResponseTrait;
    public function index()
    {
        $data = $this->userModel->findAll();
        return $this->respond($data);
    }

    public function create()
    {
        return $this->respondCreated('Tidak tersedia metode ini', 500);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($username = null)
    {
        $data = $this->userModel->findUserByUserName($username);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak tersedia data dengan nama pengguna ' . $username);
        }
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($username = null)
    {
        $data = $this->userModel->findUserByUserName($username);
        if ($data) {
            $input = [
                'id' => $data['id'],
                'username' => $username,
                'fullName' => $this->request->getVar('fullName'),
                'email' => $this->request->getVar('email'),
                'nama_panggilan' => $this->request->getVar('nama_panggilan'),
                'alamat' => $this->request->getVar('alamat'),
                'no_hp' => $this->request->getVar('no_hp'),
                'foto' => $this->request->getVar('foto'),
                'nim' => $this->request->getVar('nim'),
                'kelas_id' => $this->request->getVar('kelas_id'),
            ];
            if ($data['email'] == $input['email']) {
                $emailRules = ['rules' => 'required|valid_email', 'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                ]];
            } else {
                $emailRules = ['rules' => 'required|valid_email|is_unique[user.email]', 'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah digunakan',
                ]];
            }
            $rules = [
                'fullName' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama lengkap harus diisi',
                    ],
                ],
                'email' => $emailRules,
            ];
            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors());
            } else {
                if ($this->userModel->save($input)) {
                    $user = $this->userModel->findUserByUserName($username);
                    $response = [
                        'status' => 200,
                        'error' => null,
                        'messages' => [
                            'success' => 'Data berhasil diubah',
                        ],
                        'user' => [
                            'id' => intval($user['id']),
                            'username' => $user['username'],
                            'fullName' => $user['fullName'],
                            'nama_panggilan' => $user['nama_panggilan'],
                            'email' => $user['email'],
                            'alamat' => $user['alamat'],
                            'no_hp' => $user['no_hp'],
                            'nim' => $user['nim'],
                            'profile_photo_url' => 'https://ui-avatars.com/api/?name=a&color=7F9CF5&background=EBF4FF'
                        ]
                    ];
                } else {
                    return $this->failServerError('Gagal mengubah data');
                }
                return $this->respond($response);
            }
        } else {
            return $this->failNotFound('Tidak tersedia data dengan nama pengguna ' . $username);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($username = null)
    {
        return $this->respondCreated('Tidak tersedia metode ini', 500);
    }
}
