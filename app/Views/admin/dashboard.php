<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="admin-page-header">
    <div>
        <h1>Dashboard</h1>
        <p class="text-muted mb-0">Welcome back, <?= esc(session('user_name') ?? 'Admin') ?>.</p>
    </div>
    <a class="btn btn-primary" href="/admin/properties/create">
        <i class="bi bi-plus-lg"></i> New Property
    </a>
</div>

<div class="kpi-grid">
    <?php foreach ($kpis ?? [] as $kpi): ?>
        <div class="kpi-card">
            <div class="kpi-label"><?= esc($kpi['label']) ?></div>
            <div class="kpi-value"><?= esc($kpi['value']) ?></div>
            <div class="kpi-trend"><?= esc($kpi['trend']) ?></div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <div class="card admin-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Properties</span>
                <a href="/admin/properties" class="text-decoration-none">View all</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentProperties)): ?>
                    <p class="text-muted mb-0">No properties yet.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($recentProperties as $property): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= esc($property->title) ?></strong>
                                    <div class="text-muted small"><?= esc($property->city) ?></div>
                                </div>
                                <a href="/admin/properties/<?= esc($property->id) ?>" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>