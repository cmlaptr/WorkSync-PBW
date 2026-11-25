<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $table            = 'tugas';
    protected $primaryKey       = 'id_tugas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'judul',
        'deskripsi',
        'id_kategori',
        'id_pembuat',
        'id_penanggung_jawab',
        'deadline',
        'prioritas',
        'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'judul'               => 'required|min_length[3]|max_length[150]',
        'deskripsi'           => 'permit_empty|string',
        'id_kategori'         => 'permit_empty|integer',
        'id_pembuat'          => 'required|integer',
        'id_penanggung_jawab' => 'permit_empty|integer',
        'deadline'            => 'required|valid_date[Y-m-d]',
        'prioritas'           => 'required|in_list[rendah,sedang,tinggi]',
        'status'              => 'required|in_list[belum,proses,selesai]',
    ];

    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul tugas wajib diisi.',
        ],
        'deadline' => [
            'required'   => 'Tanggal deadline wajib ditentukan.',
            'valid_date' => 'Format tanggal deadline harus YYYY-MM-DD.',
        ],
        'prioritas' => [
            'in_list' => 'Prioritas hanya boleh bernilai rendah, sedang, atau tinggi.',
        ],
        'status' => [
            'in_list' => 'Status hanya boleh bernilai belum, proses, atau selesai.',
        ],
    ];

    /**
     * Mengambil daftar tugas lengkap dengan nama kategori, pembuat, dan penanggung jawab.
     * Jika $idPenanggungJawab diisi, hanya menampilkan tugas milik anggota tersebut.
     */
    public function getTugasLengkap(?int $idPenanggungJawab = null): array
    {
        $builder = $this->select('
                tugas.*,
                kategori.nama_kategori,
                pembuat.nama AS nama_pembuat,
                pj.nama AS nama_penanggung_jawab
            ')
            ->join('kategori', 'kategori.id_kategori = tugas.id_kategori', 'left')
            ->join('users AS pembuat', 'pembuat.id_user = tugas.id_pembuat', 'left')
            ->join('users AS pj', 'pj.id_user = tugas.id_penanggung_jawab', 'left');

        if ($idPenanggungJawab !== null) {
            $builder->where('tugas.id_penanggung_jawab', $idPenanggungJawab);
        }

        return $builder->orderBy('tugas.deadline', 'ASC')->findAll();
    }

    /**
     * Statistik ringkas untuk halaman Dashboard
     */
    public function getStatistikTugas(?int $idPenanggungJawab = null): array
    {
        $statuses = ['belum', 'proses', 'selesai'];
        $hasil    = [];

        foreach ($statuses as $st) {
            $builder = $this->where('status', $st);
            if ($idPenanggungJawab !== null) {
                $builder->where('id_penanggung_jawab', $idPenanggungJawab);
            }
            $hasil[$st] = $builder->countAllResults();
        }

        return $hasil;
    }
}