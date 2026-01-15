<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <h1>Content Management</h1>
        <p class="text-muted mb-0">Sayfa içeriklerini yönetin</p>
    </div>
</div>

<div class="row">
    <?php foreach ($pages as $pageKey => $pageConfig): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card admin-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-file-text me-2"></i>
                        <?= esc($pageConfig['label']) ?>
                    </h5>
                    <p class="card-text text-muted small">
                        <?= count($pageConfig['blocks']) ?> düzenlenebilir alan
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="/admin/content/<?= esc($pageKey) ?>" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-pencil me-1"></i> Düzenle
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>