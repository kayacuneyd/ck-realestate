<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="/admin/content">Content</a></li>
                <li class="breadcrumb-item active"><?= esc($pageLabel) ?></li>
            </ol>
        </nav>
        <h1>İçerik Düzenle: <?= esc($pageLabel) ?></h1>
        <p class="text-muted mb-0"><?= count($blocks) ?> düzenlenebilir alan</p>
    </div>
</div>

<?php if (session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>
        <?= session('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form action="/admin/content/<?= esc($page) ?>" method="post">
    <?= csrf_field() ?>

    <div class="card admin-card mb-4">
        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i> İçerik Alanları
        </div>
        <div class="card-body">
            <?php foreach ($blocks as $key => $config): ?>
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <?= esc($config['label']) ?>
                        <small class="text-muted fw-normal">(<?= esc($key) ?>)</small>
                    </label>

                    <?php if ($config['type'] === 'textarea'): ?>
                        <textarea class="form-control" name="<?= esc($key) ?>"
                            rows="4"><?= esc($content[$key] ?? '') ?></textarea>
                    <?php else: ?>
                        <input type="text" class="form-control" name="<?= esc($key) ?>"
                            value="<?= esc($content[$key] ?? '') ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i> Kaydet
        </button>
        <a href="/admin/content" class="btn btn-secondary">İptal</a>
    </div>
</form>

<?= $this->endSection() ?>