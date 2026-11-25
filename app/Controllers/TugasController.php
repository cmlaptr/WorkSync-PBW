<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\RiwayatStatusModel;
use App\Models\TugasModel;
use App\Models\UserModel;

class TugasController extends BaseController
{
    protected TugasModel $tugasModel;
    protected RiwayatStatusModel $riwayatModel;

    public function __construct()
    {
        $this->tugasModel   = new TugasModel();
        $this->riwayatModel = new RiwayatStatusModel();
    }

    public function index()
    {
        $role       = session()->get('nama_role');
        $idUser     = (int) session()->get('id_user');
        $filterUser = ($role === 'Admin') ? null : $idUser;

        $data = [
            'title' => 'Daftar Tugas',
            'tugas' => $this->tugasModel->getTugasLengkap($filterUser),
        ];

        return view('tugas/index', $data);
    }

    public function detail(int $idTugas)
    {
        $tugas = $this->tugasModel->select('
                tugas.*,
                kategori.nama_kategori,
                pembuat.nama AS nama_pembuat,
                pj.nama AS nama_penanggung_jawab
            ')
            ->join('kategori', 'kategori.id_kategori = tugas.id_kategori', 'left')
            ->join('users AS pembuat', 'pembuat.id_user = tugas.id_pembuat', 'left')
            ->join('users AS pj', 'pj.id_user = tugas.id_penanggung_jawab', 'left')
            ->where('tugas.id_tugas', $idTugas)
            ->first();

        if (! $tugas) {
            return redirect()->to('/tugas')->with('error', 'Data tugas tidak ditemukan.');
        }

        // Batasi anggota agar hanya bisa membuka detail tugas yang ditugaskan kepadanya
        if (session()->get('nama_role') !== 'Admin' && (int) $tugas['id_penanggung_jawab'] !== (int) session()->get('id_user')) {
            return redirect()->to('/tugas')->with('error', 'Anda tidak memiliki akses ke tugas ini.');
        }

        $data = [
            'title'   => 'Detail Tugas',
            'tugas'   => $tugas,
            'riwayat' => $this->riwayatModel->getRiwayatByTugas($idTugas),
        ];

        return view('tugas/detail', $data);
    }

    public function create()
    {
        $kategoriModel = new KategoriModel();
        $userModel     = new UserModel();

        $data = [
            'title'    => 'Tambah Tugas Baru',
            'kategori' => $kategoriModel->findAll(),
            'users'    => $userModel->getAllUsersWithRoles(),
        ];

        return view('tugas/create', $data);
    }

    public function store()
    {
        $idKategori        = $this->request->getPost('id_kategori');
        $idPenanggungJawab = $this->request->getPost('id_penanggung_jawab');

        $dataSimpan = [
            'judul'               => $this->request->getPost('judul'),
            'deskripsi'           => $this->request->getPost('deskripsi'),
            'id_kategori'         => ! empty($idKategori) ? (int) $idKategori : null,
            'id_pembuat'          => (int) session()->get('id_user'),
            'id_penanggung_jawab' => ! empty($idPenanggungJawab) ? (int) $idPenanggungJawab : null,
            'deadline'            => $this->request->getPost('deadline'),
            'prioritas'           => $this->request->getPost('prioritas') ?? 'sedang',
            'status'              => 'belum',
        ];

        if (! $this->tugasModel->insert($dataSimpan)) {
            return redirect()->back()->withInput()->with('errors', $this->tugasModel->errors());
        }

        $idTugasBaru = $this->tugasModel->getInsertID();

        // Catat riwayat status awal saat tugas dibuat
        $this->riwayatModel->insert([
            'id_tugas'    => $idTugasBaru,
            'id_user'     => (int) session()->get('id_user'),
            'status_lama' => null,
            'status_baru' => 'belum',
        ]);

        return redirect()->to('/tugas')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit(int $idTugas)
    {
        $tugas = $this->tugasModel->find($idTugas);
        if (! $tugas) {
            return redirect()->to('/tugas')->with('error', 'Data tugas tidak ditemukan.');
        }

        $kategoriModel = new KategoriModel();
        $userModel     = new UserModel();

        $data = [
            'title'    => 'Edit Tugas',
            'tugas'    => $tugas,
            'kategori' => $kategoriModel->findAll(),
            'users'    => $userModel->getAllUsersWithRoles(),
        ];

        return view('tugas/edit', $data);
    }

    public function update(int $idTugas)
    {
        $tugasLama = $this->tugasModel->find($idTugas);
        if (! $tugasLama) {
            return redirect()->to('/tugas')->with('error', 'Data tugas tidak ditemukan.');
        }

        $idKategori        = $this->request->getPost('id_kategori');
        $idPenanggungJawab = $this->request->getPost('id_penanggung_jawab');
        $statusBaru        = $this->request->getPost('status');

        $dataUpdate = [
            'judul'               => $this->request->getPost('judul'),
            'deskripsi'           => $this->request->getPost('deskripsi'),
            'id_kategori'         => ! empty($idKategori) ? (int) $idKategori : null,
            'id_pembuat'          => $tugasLama['id_pembuat'],
            'id_penanggung_jawab' => ! empty($idPenanggungJawab) ? (int) $idPenanggungJawab : null,
            'deadline'            => $this->request->getPost('deadline'),
            'prioritas'           => $this->request->getPost('prioritas'),
            'status'              => $statusBaru,
        ];

        if (! $this->tugasModel->update($idTugas, $dataUpdate)) {
            return redirect()->back()->withInput()->with('errors', $this->tugasModel->errors());
        }

        // Jika status ikut diubah saat edit, catat ke riwayat_status
        if ($tugasLama['status'] !== $statusBaru) {
            $this->riwayatModel->insert([
                'id_tugas'    => $idTugas,
                'id_user'     => (int) session()->get('id_user'),
                'status_lama' => $tugasLama['status'],
                'status_baru' => $statusBaru,
            ]);
        }

        return redirect()->to('/tugas')->with('success', 'Data tugas berhasil diperbarui.');
    }

    /**
     * Endpoint khusus untuk mengubah progres status tugas (dapat dilakukan Anggota maupun Admin)
     */
    public function updateStatus(int $idTugas)
    {
        $tugas = $this->tugasModel->find($idTugas);
        if (! $tugas) {
            return redirect()->to('/tugas')->with('error', 'Tugas tidak ditemukan.');
        }

        $role   = session()->get('nama_role');
        $idUser = (int) session()->get('id_user');

        if ($role !== 'Admin' && (int) $tugas['id_penanggung_jawab'] !== $idUser) {
            return redirect()->to('/tugas')->with('error', 'Anda tidak berhak mengubah status tugas ini.');
        }

        $statusBaru = $this->request->getPost('status');
        if (! in_array($statusBaru, ['belum', 'proses', 'selesai'], true)) {
            return redirect()->back()->with('error', 'Nilai status tidak valid.');
        }

        if ($tugas['status'] !== $statusBaru) {
            $this->tugasModel->update($idTugas, ['status' => $statusBaru]);

            $this->riwayatModel->insert([
                'id_tugas'    => $idTugas,
                'id_user'     => $idUser,
                'status_lama' => $tugas['status'],
                'status_baru' => $statusBaru,
            ]);
        }

        return redirect()->back()->with('success', 'Status tugas berhasil diperbarui menjadi "' . $statusBaru . '".');
    }

    public function delete(int $idTugas)
    {
        if (! $this->tugasModel->find($idTugas)) {
            return redirect()->to('/tugas')->with('error', 'Data tugas tidak ditemukan.');
        }

        $this->tugasModel->delete($idTugas);
        return redirect()->to('/tugas')->with('success', 'Tugas berhasil dihapus.');
    }
}