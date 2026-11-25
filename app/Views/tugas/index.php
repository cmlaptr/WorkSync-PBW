<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Daftar Tugas') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?= $this->include('layout/navbar') ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Tugas</h4>
        <?php if (session()->get('nama_role') === 'Admin'): ?>
            <a href="<?= site_url('tugas/create') ?>" class="btn btn-primary btn-sm">+ Tambah Tugas</a>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penanggung Jawab</th>
                        <th>Deadline</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tugas)): ?>
                        <tr><td colspan="8" class="text-center text-muted">Belum ada data tugas.</td></tr>
                    <?php else: ?>
                        <?php foreach ($tugas as $i => $row): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($row['judul']) ?></td>
                                <td><?= esc($row['nama_kategori'] ?? '-') ?></td>
                                <td><?= esc($row['nama_penanggung_jawab'] ?? '-') ?></td>
                                <td><?= esc($row['deadline']) ?></td>
                                <td><?= esc(ucfirst($row['prioritas'])) ?></td>
                                <td>
                                    <form action="<?= site_url('tugas/update-status/' . $row['id_tugas']) ?>" method="post" class="d-flex gap-1">
                                        <?= csrf_field() ?>
                                        <select name="status" class="form-select form-select-sm" style="width: 115px;">
                                            <option value="belum" <?= $row['status'] === 'belum' ? 'selected' : '' ?>>Belum</option>
                                            <option value="proses" <?= $row['status'] === 'proses' ? 'selected' : '' ?>>Proses</option>
                                            <option value="selesai" <?= $row['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Simpan</button>
                                    </form>
                                </td>
                                <td class="text-nowrap">
                                    <a href="<?= site_url('tugas/detail/' . $row['id_tugas']) ?>" class="btn btn-sm btn-info text-white">Detail</a>
                                    <?php if (session()->get('nama_role') === 'Admin'): ?>
                                        <a href="<?= site_url('tugas/edit/' . $row['id_tugas']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="<?= site_url('tugas/delete/' . $row['id_tugas']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus tugas ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
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