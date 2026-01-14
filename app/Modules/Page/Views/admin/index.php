<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <h1><?= esc($title) ?></h1>
        <p class="text-muted mb-0">Manage content pages and publishing status.</p>
    </div>
    <a href="/admin/pages/create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> New Page
    </a>
</div>

<?= view('components/alerts') ?>

<form class="admin-toolbar" method="get" action="/admin/pages">
    <input type="text" name="q" class="form-control" placeholder="Search title or slug"
        value="<?= esc($filters['q'] ?? '') ?>">
    <select name="status" class="form-select">
        <option value="">All Status</option>
        <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
        <option value="inactive" <?= ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
    </select>
    <button type="submit" class="btn btn-outline-secondary">Filter</button>
    <a href="/admin/pages" class="btn btn-outline-secondary">Reset</a>
</form>

<div class="card admin-card">
    <div class="card-body">
        <?php if (empty($pages)): ?>
            <p class="text-muted text-center py-4">No pages found.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $page): ?>
                            <tr>
                                <td><?= esc($page->id) ?></td>
                                <td>
                                    <a href="/admin/pages/<?= esc($page->id) ?>">
                                        <?= esc($page->title) ?>
                                    </a>
                                </td>
                                <td><?= esc($page->slug) ?></td>
                                <td>
                                    <?php if ((int) $page->is_active === 1): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="/admin/pages/<?= esc($page->id) ?>"
                                            class="btn btn-sm btn-outline-secondary btn-action" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/admin/pages/<?= esc($page->id) ?>/edit"
                                            class="btn btn-sm btn-outline-primary btn-action" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="/admin/pages/<?= esc($page->id) ?>/delete" method="post"
                                            class="d-inline" onsubmit="return confirm('Delete this page?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action"
                                                title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
