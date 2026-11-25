<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('dashboard') ?>">WorkSync</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="<?= site_url('dashboard') ?>">Dashboard</a>
            <a class="nav-link" href="<?= site_url('tugas') ?>">Tugas</a>
            <?php if (session()->get('nama_role') === 'Admin'): ?>
                <a class="nav-link" href="<?= site_url('kategori') ?>">Kategori</a>
                <a class="nav-link" href="<?= site_url('users') ?>">Pengguna</a>
            <?php endif; ?>
        </div>
        <div class="d-flex align-items-center text-white gap-2 small">
            <span><?= esc(session()->get('nama')) ?> (<?= esc(session()->get('nama_role')) ?>)</span>
            <a href="<?= site_url('logout') ?>" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if ($errors = session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                <?php foreach ($errors as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>