<?php

namespace App\Controllers;

use Exception;
use ReflectionException;
use App\Models\AuthModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\Response;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    /**
     * Register a new user
     * @return Response
     * @throws ReflectionException
     */


    public function __construct()
    {
        $this->authModel = new AuthModel();
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function register()
    {
        $rules = [
            'username' => [
                'rules' => 'required|is_unique[auth.username]',
                'errors' => [
                    'required' => 'Nama pengguna harus diisi',
                    'is_unique' => 'Nama pengguna sudah digunakan',
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Kata sandi harus diisi',
                    'min_length' => 'Kata sandi minimal 8 karakter',
                ],
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[user.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah digunakan',
                ],
            ],
            'fullName' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi',
                ],
            ],
        ];
        $dataAuth = [
            'username' => $this->getRequestInput($this->request)['username'],
            'password' => $this->getRequestInput($this->request)['password'],
        ];
        $dataUser = [
            'username' => $this->getRequestInput($this->request)['username'],
            'email' => $this->getRequestInput($this->request)['email'],
            'fullName' => $this->getRequestInput($this->request)['fullName'],
        ];
        if (!$this->validate($rules)) {
            return $this->getResponse(
                ['message' => $this->validator->getErrors()],
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
        $dataAuth['role_id'] = 3;
        $this->authModel->insert($dataAuth);
        $this->userModel->insert($dataUser);
        $auth = $this->authModel->findUserByUserName($dataAuth['username']);
        $user = $this->userModel->findUserByUserName($dataAuth['username']);
        unset($auth['password']);
        $role = $this->roleModel->find($auth['role_id']);
        helper('auth');
        return $this->getResponse(
            [
                'message' => 'Pendaftaran berhasil',
                "token" => getSignedJWTForUser($dataAuth['username']),
                'type' => 'Bearer',
                'tokenType' => 'Bearer',
                'accessToken' => getSignedJWTForUser($dataAuth['username']),
                'user' => [
                    'id' => intval($user['id']),
                    'username' => $auth['username'],
                    'fullName' => $user['fullName'],
                    'nama_panggilan' => $user['nama_panggilan'],
                    'email' => $user['email'],
                    'alamat' => $user['alamat'],
                    'no_hp' => $user['no_hp'],
                    'profile_photo_url' => 'https://ui-avatars.com/api/?name=' . $user['username'] . '&background=0D8ABC&color=fff',
                    'nim' => $user['nim'],
                    'kelas_id' =>$user['kelas_id'],
                    'roles' => $role['name'],
                ]
            ],
            ResponseInterface::HTTP_CREATED
        );
    }
    /**
     * Authenticate Existing User
     * @return Response
     */
    public function login()
    {
        $rules = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama pengguna harus diisi',
                ],
            ],
            'password' => [
                'rules' => 'required|validateUser[username, password]',
                'errors' => [
                    'required' => 'Kata sandi harus diisi',
                    'validateUser' => 'Nama pengguna atau kata sandi salah',
                ],
            ]
        ];
        $input = $this->getRequestInput($this->request);
        $user = $this->authModel->findUserByUserName($input['username']);
        if (!$this->validateRequest($input, $rules)) {
            return $this
                ->getResponse(
                    ['message' => $this->validator->getErrors()],
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }
        if (!$user) {
            return $this
                ->getResponse(
                    ['message' => 'Nama pengguna atau kata sandi salah'],
                    ResponseInterface::HTTP_UNAUTHORIZED
                );
        }
        return $this->getJWTForUser($input['username']);
    }

    private function getJWTForUser(
        string $username,
        int $responseCode = ResponseInterface::HTTP_OK
    ) {
        try {
            $auth = $this->authModel->findUserByUserName($username);
            $user = $this->userModel->findUserByUserName($username);
            unset($auth['password']);
            $role = $this->roleModel->find($auth['role_id']);
            helper('auth');
            return $this
                ->getResponse(
                    [
                        "token" => getSignedJWTForUser($username),
                        'type' => 'Bearer',
                        'tokenType' => 'Bearer',
                        'accessToken' => getSignedJWTForUser($username),
                        'user' => [
                            'id' => intval($user['id']),
                            'username' => $auth['username'],
                            'fullName' => $user['fullName'],
                            'nama_panggilan' => $user['nama_panggilan'],
                            'email' => $user['email'],
                            'alamat' => $user['alamat'],
                            'no_hp' => $user['no_hp'],
                            'profile_photo_url' => 'https://ui-avatars.com/api/?name=' . $user['username'] . '&background=0D8ABC&color=fff',
                            'nim' => $user['nim'],
                            'kelas_id' => $user['kelas_id'],
                            'roles' => $role['name'],
                        ]
                    ]
                );
        } catch (Exception $exception) {
            return $this
                ->getResponse(
                    [
                        'error' => $exception->getMessage(),
                    ],
                    $responseCode
                );
        }
    }

    public function logout()
    {
        return $this->getResponse(['message' => 'Logout berhasil']);
    }

    public function changepassword()
    {
        $rules = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama pengguna harus diisi',
                ],
            ],
            'oldPassword' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kata sandi lama harus diisi',
                ],
            ],
            'newPassword' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Kata sandi baru harus diisi',
                    'min_length' => 'Kata sandi baru minimal 8 karakter',
                ],
            ],
        ];
        $input = $this->getRequestInput($this->request);
        $user = $this->authModel->findUserByUserName($input['username']);
        if (!$this->validateRequest($input, $rules)) {
            return $this
                ->getResponse(
                    ['message' => $this->validator->getErrors()],
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }
        if (!$user) {
            return $this
                ->getResponse(
                    ['message' => 'Nama pengguna atau kata sandi salah'],
                    ResponseInterface::HTTP_UNAUTHORIZED
                );
        }
        if (!password_verify($input['oldPassword'], $user['password'])) {
            return $this
                ->getResponse(
                    ['message' => 'Kata sandi lama salah'],
                    ResponseInterface::HTTP_UNAUTHORIZED
                );
        }
        $dataAuth = [
            'username' => $this->getRequestInput($this->request)['username'],
            'password' => $this->getRequestInput($this->request)['newPassword'],
        ];
        $this->authModel->update($user['username'], $dataAuth);
        return $this->getResponse(
            ['message' => 'Kata sandi berhasil diubah'],
            ResponseInterface::HTTP_CREATED
        );
    }
}
