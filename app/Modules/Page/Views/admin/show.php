<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <h1><?= esc($page->title) ?></h1>
        <p class="text-muted mb-0">Slug: <?= esc($page->slug) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="/admin/pages/<?= esc($page->id) ?>/edit" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="/admin/pages" class="btn btn-outline-secondary">Back to list</a>
    </div>
</div>

<div class="card admin-card">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="text-muted small mb-1">Meta Title</div>
                <div><?= esc($page->meta_title) ?></div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small mb-1">Meta Description</div>
                <div><?= esc($page->meta_description) ?></div>
            </div>
            <div class="col-md-12">
                <div class="text-muted small mb-1">Content</div>
                <div><?= nl2br(esc($page->content)) ?></div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small mb-1">Status</div>
                <div>
                    <?php if ((int) $page->is_active === 1): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
