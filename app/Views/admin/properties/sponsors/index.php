<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= esc($title) ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/admin/sponsors/create" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Yeni Ekle
        </a>
    </div>
</div>

<?php if (session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>Sıra</th>
                <th>Logo</th>
                <th>İsim</th>
                <th>Web Sitesi</th>
                <th class="text-end">İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($sponsors)): ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Henüz sponsor eklenmemiş.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($sponsors as $sponsor): ?>
                    <tr>
                        <td><?= esc($sponsor['sort_order']) ?></td>
                        <td>
                            <img src="<?= esc($sponsor['logo_url']) ?>" alt="Logo" class="img-thumbnail" style="height: 50px;">
                        </td>
                        <td class="fw-bold"><?= esc($sponsor['name']) ?></td>
                        <td>
                            <?php if ($sponsor['website_url']): ?>
                                <a href="<?= esc($sponsor['website_url']) ?>" target="_blank" class="text-decoration-none">
                                    <i class="bi bi-link-45deg"></i> Link
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="/admin/sponsors/edit/<?= $sponsor['id'] ?>" class="btn btn-sm btn-outline-secondary me-2">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="/admin/sponsors/delete/<?= $sponsor['id'] ?>" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Bu sponsoru silmek istediğinizden emin misiniz?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>