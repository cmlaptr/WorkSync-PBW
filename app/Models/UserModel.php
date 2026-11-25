<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'email', 'password'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Tabel users hanya memiliki kolom created_at

    protected $validationRules = [
        'id_user'  => 'permit_empty|integer',
        'nama'     => 'required|min_length[3]|max_length[100]',
        'email'    => 'required|valid_email|max_length[100]|is_unique[users.email,id_user,{id_user}]',
        'password' => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique'   => 'Email sudah terdaftar, gunakan email lain.',
            'valid_email' => 'Format email tidak valid.',
        ],
    ];

    /**
     * Mengambil data user beserta role-nya untuk proses login & manajemen user
     */
    public function getUserWithRoleByEmail(string $email): ?array
    {
        return $this->select('users.*, roles.id_role, roles.nama_role')
            ->join('user_roles', 'user_roles.id_user = users.id_user', 'left')
            ->join('roles', 'roles.id_role = user_roles.id_role', 'left')
            ->where('users.email', $email)
            ->first();
    }

    /**
     * Mengambil seluruh daftar user beserta role-nya
     */
    public function getAllUsersWithRoles(): array
    {
        return $this->select('users.id_user, users.nama, users.email, users.created_at, roles.id_role, roles.nama_role')
            ->join('user_roles', 'user_roles.id_user = users.id_user', 'left')
            ->join('roles', 'roles.id_role = user_roles.id_role', 'left')
            ->orderBy('users.nama', 'ASC')
            ->findAll();
    }

    /**
     * Simpan user baru sekaligus relasi ke tabel user_roles secara atomic
     */
    public function createUserWithRole(array $userData, int $idRole): bool
    {
        $this->db->transStart();

        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        $this->insert($userData);
        $idUser = $this->getInsertID();

        if ($idUser) {
            $this->db->table('user_roles')->insert([
                'id_user' => $idUser,
                'id_role' => $idRole,
            ]);
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }
}