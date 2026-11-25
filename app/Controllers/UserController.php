<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $db    = \Config\Database::connect();
        $roles = $db->table('roles')->get()->getResultArray();

        $data = [
            'title' => 'Kelola Pengguna',
            'users' => $this->userModel->getAllUsersWithRoles(),
            'roles' => $roles,
        ];

        return view('users/index', $data);
    }

    public function store()
    {
        $userData = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];
        $idRole = (int) $this->request->getPost('id_role');

        // Validasi input sebelum transaksi
        if (! $this->userModel->validate($userData)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        if (! in_array($idRole, [1, 2], true)) {
            return redirect()->back()->withInput()->with('error', 'Role pengguna tidak valid.');
        }

        if (! $this->userModel->createUserWithRole($userData, $idRole)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan pengguna baru.');
        }

        return redirect()->to('/users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function delete(int $idUser)
    {
        if ($idUser === (int) session()->get('id_user')) {
            return redirect()->to('/users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $this->userModel->delete($idUser);
        return redirect()->to('/users')->with('success', 'Pengguna berhasil dihapus.');
    }
}