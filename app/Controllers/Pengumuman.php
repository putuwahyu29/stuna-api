<?php

namespace App\Controllers;

use App\Models\PengumumanModel;
use App\Libraries\Slug;
use CodeIgniter\RESTful\ResourceController;

class Pengumuman extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }
    public function index()
    {
        $data = $this->pengumumanModel->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($slug = null)
    {
        $data = $this->pengumumanModel->findPengumumanBySlug($slug);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak ditemukan pengumuman dengan slug ' . $slug);
        }
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        helper(['text']);
        $rules = [
            'judul' => ['rules' => 'required|min_length[3]', 'errors' => ['required' => 'Judul harus disi.', 'min_length' => 'Judul setidaknya terdiri dari 3 karakter.']],
            'isi' => ['rules' => 'required', 'errors' => ['required' => 'Isi harus disi.']],
            'slug' => ['rules' => 'required', 'errors' => ['required' => 'Slug harus disi.']],
            'gambar' => ['rules' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]', 'errors' => ['uploaded' => 'Gambar harus diupload.', 'max_size' => 'Ukuran gambar terlalu besar.', 'is_image' => 'File yang diupload bukan gambar.', 'mime_in' => 'File yang diupload bukan gambar.']]
        ];
        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        } else {
            $gambar = $this->request->getFile('gambar');
            $namaGambar = $gambar->getRandomName();
            $gambar->move('uploads/pengumuman', $namaGambar);
            $data = [
                'judul' => $this->request->getVar('judul'),
                'isi' => $this->request->getVar('isi'),
                'user_id' => $this->request->getVar('user_id'),
                'kelas_id' => $this->request->getVar('kelas_id'),
                'gambar' => $namaGambar,
            ];
            $Slug = new Slug([
                'field' => 'slug',
                'title' => 'judul',
                'table' => 'pengumuman',
                'id'     => 'id',
            ]);
            $data['slug'] = $Slug->create_uri(['judul' => $data['judul']]);
            $data['excerpt'] = excerpt($data['isi']);
            if ($this->pengumumanModel->insert($data)) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Data Pengumuman Berhasil Ditambahkan'
                    ]
                ];
            } else {
                $response = [
                    'status' => 500,
                    'error' => null,
                    'messages' => [
                        'error' => $this->pengumumanModel->errors()
                    ]
                ];
            }
        }


        return $this->respond($response);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($slug = null)
    {
        helper(['text']);
        $pengumuman = $this->pengumumanModel->findPengumumanBySlug($slug);
        if ($pengumuman) {
            $rules = [
                'judul' => ['rules' => 'required|min_length[3]', 'errors' => ['required' => 'Judul harus disi.', 'min_length' => 'Judul setidaknya terdiri dari 3 karakter.']],
                'isi' => ['rules' => 'required', 'errors' => ['required' => 'Isi harus disi.']],
                'slug' => ['rules' => 'required', 'errors' => ['required' => 'Slug harus disi.']],
                'gambar' => ['rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]', 'errors' => ['uploaded' => 'Gambar harus diupload.', 'max_size' => 'Ukuran gambar terlalu besar.', 'is_image' => 'File yang diupload bukan gambar.', 'mime_in' => 'File yang diupload bukan gambar.']]
            ];
            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors());
            } else {
                $gambar = $this->request->getFile('gambar');
                if ($gambar) {
                    $namaGambar = $gambar->getRandomName();
                    $gambar->move('uploads/pengumuman', $namaGambar);
                    if ($pengumuman['gambar'] == $this->request->getVar('gambarLama')) {
                        unlink('uploads/pengumuman/' . $this->request->getVar('gambarLama'));
                    }
                } else {
                    $namaGambar = $this->request->getVar('gambarLama');
                }
                $data = [
                    'judul' => $this->request->getVar('judul'),
                    'isi' => $this->request->getVar('isi'),
                    'gambar' => $namaGambar,
                    'user_id' => $this->request->getVar('user_id'),
                    'kelas_id' => $this->request->getVar('kelas_id'),
                ];
                $Slug = new Slug([
                    'field' => 'slug',
                    'title' => 'judul',
                    'table' => 'pengumuman',
                    'id'     => 'id',
                ]);
                $data['excerpt'] = excerpt($data['isi']);
                $data['slug'] = $Slug->create_uri(['judul' => $data['judul']], $pengumuman['id']);
                if ($this->pengumumanModel->update($pengumuman['id'], $data)) {
                    $response = [
                        'status' => 200,
                        'error' => null,
                        'messages' => [
                            'success' => 'Data Pengumuman Berhasil Diubah'
                        ]
                    ];
                } else {
                    $response = [
                        'status' => 500,
                        'error' => null,
                        'messages' => [
                            'error' => $this->pengumumanModel->errors()
                        ]
                    ];
                }
            }
        } else {
            $response = [
                'status' => 500,
                'error' => null,
                'messages' => [
                    'error' => 'Tidak ditemukan pengumuman dengan slug ' . $slug
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
    public function delete($slug = null)
    {
        $pengumuman = $this->pengumumanModel->findPengumumanBySlug($slug);
        if ($pengumuman) {
            if ($this->pengumumanModel->delete($pengumuman['id'])) {
                $response = [
                    'status' => 200,
                    'error' => null,
                    'messages' => [
                        'success' => 'Data Pengumuman Berhasil Dihapus'
                    ]
                ];
            } else {
                $response = [
                    'status' => 500,
                    'error' => null,
                    'messages' => [
                        'error' => $this->pengumumanModel->errors()
                    ]
                ];
            }
        } else {
            $response = [
                'status' => 500,
                'error' => null,
                'messages' => [
                    'error' => 'Data Pengumuman Tidak Ditemukan'
                ]
            ];
        }
        return $this->respondDeleted($response);
    }
}
