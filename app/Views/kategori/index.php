<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kelola Kategori') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?= $this->include('layout/navbar') ?>

<div class="container">
    <h4 class="mb-3">Kelola Kategori</h4>

    <div class="card mb-4">
        <div class="card-body">
            <form action="<?= site_url('kategori/store') ?>" method="post" class="row g-2">
                <?= csrf_field() ?>
                <div class="col-md-8">
                    <input type="text" name="nama_kategori" class="form-control" placeholder="Nama kategori baru" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Tambah Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Nama Kategori</th>
                        <th style="width: 260px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kategori)): ?>
                        <tr><td colspan="3" class="text-center text-muted">Belum ada kategori.</td></tr>
                    <?php else: ?>
                        <?php foreach ($kategori as $i => $k): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td>
                                    <form action="<?= site_url('kategori/update/' . $k['id_kategori']) ?>" method="post" class="d-flex gap-2">
                                        <?= csrf_field() ?>
                                        <input type="text" name="nama_kategori" class="form-control form-control-sm" value="<?= esc($k['nama_kategori']) ?>" required>
                                        <button type="submit" class="btn btn-sm btn-warning">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="<?= site_url('kategori/delete/' . $k['id_kategori']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
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