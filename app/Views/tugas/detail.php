<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Detail Tugas') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?= $this->include('layout/navbar') ?>

<div class="container">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Detail Tugas</span>
            <a href="<?= site_url('tugas') ?>" class="btn btn-sm btn-secondary">Kembali</a>
        </div>
        <div class="card-body">
            <h5><?= esc($tugas['judul']) ?></h5>
            <p class="text-muted"><?= nl2br(esc($tugas['deskripsi'] ?? '-')) ?></p>
            <hr>
            <div class="row small">
                <div class="col-md-3"><strong>Kategori:</strong> <?= esc($tugas['nama_kategori'] ?? '-') ?></div>
                <div class="col-md-3"><strong>Pembuat:</strong> <?= esc($tugas['nama_pembuat'] ?? '-') ?></div>
                <div class="col-md-3"><strong>Penanggung Jawab:</strong> <?= esc($tugas['nama_penanggung_jawab'] ?? '-') ?></div>
                <div class="col-md-3"><strong>Deadline:</strong> <?= esc($tugas['deadline']) ?></div>
            </div>
            <div class="row small mt-2">
                <div class="col-md-3"><strong>Prioritas:</strong> <?= esc(ucfirst($tugas['prioritas'])) ?></div>
                <div class="col-md-3"><strong>Status Saat Ini:</strong> <?= esc(ucfirst($tugas['status'])) ?></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Riwayat Perubahan Status</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm mb-0">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Diubah Oleh</th>
                        <th>Status Lama</th>
                        <th>Status Baru</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                        <tr><td colspan="4" class="text-center text-muted">Belum ada riwayat.</td></tr>
                    <?php else: ?>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td><?= esc($r['tanggal_perubahan']) ?></td>
                                <td><?= esc($r['nama_pengubah'] ?? '-') ?></td>
                                <td><?= esc($r['status_lama'] ?? '-') ?></td>
                                <td><?= esc($r['status_baru']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>