<?php

namespace App\Controllers;

use App\Models\TugasModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $tugasModel = new TugasModel();
        $role       = session()->get('nama_role');
        $idUser     = (int) session()->get('id_user');

        // Admin melihat semua tugas, Anggota hanya melihat tugas miliknya
        $filterUser = ($role === 'Admin') ? null : $idUser;

        $data = [
            'title'       => 'Dashboard - WorkSync',
            'statistik'   => $tugasModel->getStatistikTugas($filterUser),
            'daftarTugas' => $tugasModel->getTugasLengkap($filterUser),
            'hariIni'     => date('Y-m-d'),
        ];

        return view('dashboard/index', $data);
    }
}