<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Tambah Tugas') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?= $this->include('layout/navbar') ?>

<div class="container">
    <div class="card">
        <div class="card-header">Tambah Tugas Baru</div>
        <div class="card-body">
            <form action="<?= site_url('tugas/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Judul Tugas</label>
                    <input type="text" name="judul" class="form-control" value="<?= old('judul') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control"><?= old('deskripsi') ?></textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select">
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>" <?= old('id_kategori') == $k['id_kategori'] ? 'selected' : '' ?>>
                                    <?= esc($k['nama_kategori']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Penanggung Jawab</label>
                        <select name="id_penanggung_jawab" class="form-select">
                            <option value="">-- Belum Ditentukan --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id_user'] ?>" <?= old('id_penanggung_jawab') == $u['id_user'] ? 'selected' : '' ?>>
                                    <?= esc($u['nama']) ?> (<?= esc($u['nama_role'] ?? '-') ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Deadline</label>
                        <input type="date" name="deadline" class="form-control" value="<?= old('deadline') ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Prioritas</label>
                    <select name="prioritas" class="form-select">
                        <option value="rendah" <?= old('prioritas') === 'rendah' ? 'selected' : '' ?>>Rendah</option>
                        <option value="sedang" <?= old('prioritas', 'sedang') === 'sedang' ? 'selected' : '' ?>>Sedang</option>
                        <option value="tinggi" <?= old('prioritas') === 'tinggi' ? 'selected' : '' ?>>Tinggi</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= site_url('tugas') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>