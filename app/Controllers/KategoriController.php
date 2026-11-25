<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class KategoriController extends BaseController
{
    protected KategoriModel $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Kelola Kategori',
            'kategori' => $this->kategoriModel->orderBy('nama_kategori', 'ASC')->findAll(),
        ];

        return view('kategori/index', $data);
    }

    public function store()
    {
        $data = ['nama_kategori' => $this->request->getPost('nama_kategori')];

        if (! $this->kategoriModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->kategoriModel->errors());
        }

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(int $idKategori)
    {
        $data = [
            'id_kategori'   => $idKategori,
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ];

        if (! $this->kategoriModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->kategoriModel->errors());
        }

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete(int $idKategori)
    {
        $this->kategoriModel->delete($idKategori);
        return redirect()->to('/kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}