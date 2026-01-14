<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <h1><?= esc($agent->name) ?></h1>
        <p class="text-muted mb-0"><?= esc($agent->title) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="/admin/agents/<?= esc($agent->id) ?>/edit" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="/admin/agents" class="btn btn-outline-secondary">Back to list</a>
    </div>
</div>

<div class="card admin-card">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-muted small mb-1">Email</div>
                <div><?= esc($agent->email) ?></div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small mb-1">Phone</div>
                <div><?= esc($agent->phone) ?></div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small mb-1">Status</div>
                <div>
                    <?php if ((int) $agent->is_active === 1): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="text-muted small mb-1">Bio</div>
                <div><?= nl2br(esc($agent->bio)) ?></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
