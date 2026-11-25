<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?= $this->include('layout/navbar') ?>

<div class="container">
    <h4 class="mb-3">Dashboard</h4>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body">
                    <div class="text-muted small">Belum Dikerjakan</div>
                    <h3><?= (int) ($statistik['belum'] ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="text-muted small">Sedang Diproses</div>
                    <h3><?= (int) ($statistik['proses'] ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <div class="text-muted small">Selesai</div>
                    <h3><?= (int) ($statistik['selesai'] ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Daftar Tugas & Tenggat</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm align-middle mb-0">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Penanggung Jawab</th>
                        <th>Deadline</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarTugas)): ?>
                        <tr><td colspan="5" class="text-center text-muted">Belum ada tugas.</td></tr>
                    <?php else: ?>
                        <?php foreach ($daftarTugas as $t): ?>
                            <?php $lewatDeadline = ($t['status'] !== 'selesai' && $t['deadline'] < $hariIni); ?>
                            <tr class="<?= $lewatDeadline ? 'table-danger' : '' ?>">
                                <td><a href="<?= site_url('tugas/detail/' . $t['id_tugas']) ?>"><?= esc($t['judul']) ?></a></td>
                                <td><?= esc($t['nama_penanggung_jawab'] ?? '-') ?></td>
                                <td><?= esc($t['deadline']) ?> <?= $lewatDeadline ? '<span class="badge bg-danger">Terlambat</span>' : '' ?></td>
                                <td><?= esc(ucfirst($t['prioritas'])) ?></td>
                                <td><?= esc(ucfirst($t['status'])) ?></td>
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