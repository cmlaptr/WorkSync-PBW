<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Edit Tugas') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?= $this->include('layout/navbar') ?>

<div class="container">
    <div class="card">
        <div class="card-header">Edit Tugas</div>
        <div class="card-body">
            <form action="<?= site_url('tugas/update/' . $tugas['id_tugas']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Judul Tugas</label>
                    <input type="text" name="judul" class="form-control" value="<?= old('judul', $tugas['judul']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control"><?= old('deskripsi', $tugas['deskripsi']) ?></textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select">
                            <option value="">-- Pilih Kategori --</option>
                            <?php $katVal = old('id_kategori', $tugas['id_kategori']); ?>
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>" <?= $katVal == $k['id_kategori'] ? 'selected' : '' ?>>
                                    <?= esc($k['nama_kategori']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Penanggung Jawab</label>
                        <select name="id_penanggung_jawab" class="form-select">
                            <option value="">-- Belum Ditentukan --</option>
                            <?php $pjVal = old('id_penanggung_jawab', $tugas['id_penanggung_jawab']); ?>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id_user'] ?>" <?= $pjVal == $u['id_user'] ? 'selected' : '' ?>>
                                    <?= esc($u['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Deadline</label>
                        <input type="date" name="deadline" class="form-control" value="<?= old('deadline', $tugas['deadline']) ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Prioritas</label>
                        <?php $prioVal = old('prioritas', $tugas['prioritas']); ?>
                        <select name="prioritas" class="form-select">
                            <option value="rendah" <?= $prioVal === 'rendah' ? 'selected' : '' ?>>Rendah</option>
                            <option value="sedang" <?= $prioVal === 'sedang' ? 'selected' : '' ?>>Sedang</option>
                            <option value="tinggi" <?= $prioVal === 'tinggi' ? 'selected' : '' ?>>Tinggi</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <?php $statVal = old('status', $tugas['status']); ?>
                    <select name="status" class="form-select">
                        <option value="belum" <?= $statVal === 'belum' ? 'selected' : '' ?>>Belum</option>
                        <option value="proses" <?= $statVal === 'proses' ? 'selected' : '' ?>>Proses</option>
                        <option value="selesai" <?= $statVal === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= site_url('tugas') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>