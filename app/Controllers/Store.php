<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\StoreModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Store extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->authModel = new AuthModel();
        $this->storeModel = new StoreModel();
    }

    public function getAllAdmin()
    {
        $data = $this->storeModel->getAllAdmin();
        return $this->respond($data);
    }

    public function getAllUser()
    {
        $data = $this->storeModel->getAllUser();
        return $this->respond($data);
    }

    public function setRoleToAdmin($username)
    {
        if ($this->authModel->findUserByUsername($username)) {
            $this->storeModel->setRoleToAdmin($username);
            return $this->respond(['message' => 'Berhasil mengubah role user menjadi admin'], ResponseInterface::HTTP_OK);
        } else {
            return $this->failNotFound('User tidak ditemukan');
        }
    }

    public function deleteRoleAdmin($username)
    {
        if ($this->authModel->findUserByUsername($username)) {
            $this->storeModel->deleteRoleAdmin($username);
            return $this->respond(['message' => 'Berhasil menghapus role admin'], ResponseInterface::HTTP_OK);
        } else {
            return $this->failNotFound('User tidak ditemukan');
        }
    }

    public function deleteKelasUser($username)
    {
        if ($this->authModel->findUserByUsername($username)) {
            $this->storeModel->deleteKelasUser($username);
            return $this->respond(['message' => 'Berhasil menghapus kelas user'], ResponseInterface::HTTP_OK);
        } else {
            return $this->failNotFound('User tidak ditemukan');
        }
    }

    public function getPengumumanByKelasId($id)
    {
        $data = $this->storeModel->getPengumumanByKelasId($id);
        return $this->respond($data);
    }
    public function getPengumumanByKelasIdLimit($id)
    {
        $data = $this->storeModel->getPengumumanByKelasIdLimit($id);
        return $this->respond($data);
    }

    public function getPengumumanTerbaru($id)
    {
        $data = $this->storeModel->getPengumumanTerbaru($id);
        return $this->respond($data);
    }

    public function getUserByKelasId($id)
    {
        $data = $this->storeModel->getUserByKelasId($id);
        return $this->respond($data);
    }
}
