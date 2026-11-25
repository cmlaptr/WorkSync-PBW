<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_kategori'];

    protected $validationRules = [
        'id_kategori'   => 'permit_empty|integer',
        'nama_kategori' => 'required|min_length[3]|max_length[100]|is_unique[kategori.nama_kategori,id_kategori,{id_kategori}]',
    ];

    protected $validationMessages = [
        'nama_kategori' => [
            'required'  => 'Nama kategori wajib diisi.',
            'is_unique' => 'Nama kategori sudah ada.',
        ],
    ];
}