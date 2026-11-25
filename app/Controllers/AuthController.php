<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user      = $userModel->getUserWithRoleByEmail($email);

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        session()->set([
            'id_user'    => $user['id_user'],
            'nama'       => $user['nama'],
            'email'      => $user['email'],
            'id_role'    => $user['id_role'],
            'nama_role'  => $user['nama_role'] ?? 'Anggota',
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard')->with('success', 'Selamat datang, ' . $user['nama'] . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }
}