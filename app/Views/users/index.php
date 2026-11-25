<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kelola Pengguna') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?= $this->include('layout/navbar') ?>

<div class="container">
    <h4 class="mb-3">Kelola Pengguna</h4>

    <div class="card mb-4">
        <div class="card-body">
            <form action="<?= site_url('users/store') ?>" method="post" class="row g-2">
                <?= csrf_field() ?>
                <div class="col-md-3">
                    <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" required>
                </div>
                <div class="col-md-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col-md-2">
                    <input type="password" name="password" class="form-control" placeholder="Password (min 6)" required>
                </div>
                <div class="col-md-2">
                    <select name="id_role" class="form-select" required>
                        <?php foreach ($roles as $r): ?>
                            <option value="<?= $r['id_role'] ?>"><?= esc($r['nama_role']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="5" class="text-center text-muted">Belum ada pengguna.</td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $i => $u): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($u['nama']) ?></td>
                                <td><?= esc($u['email']) ?></td>
                                <td><?= esc($u['nama_role'] ?? '-') ?></td>
                                <td>
                                    <form action="<?= site_url('users/delete/' . $u['id_user']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?')">
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