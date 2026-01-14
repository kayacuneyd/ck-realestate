<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <h1><?= esc($title) ?></h1>
        <p class="text-muted mb-0">Manage property listings and availability.</p>
    </div>
    <a href="/admin/properties/create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> <?= lang('Property.admin.create') ?>
    </a>
</div>

<form class="admin-toolbar" method="get" action="/admin/properties">
    <input type="text" name="q" class="form-control" placeholder="Search title, city, description"
        value="<?= esc($filters['q'] ?? '') ?>">
    <select name="status" class="form-select">
        <option value="">All Status</option>
        <option value="available" <?= ($filters['status'] ?? '') === 'available' ? 'selected' : '' ?>>
            <?= lang('Property.status.available') ?>
        </option>
        <option value="reserved" <?= ($filters['status'] ?? '') === 'reserved' ? 'selected' : '' ?>>
            <?= lang('Property.status.reserved') ?>
        </option>
        <option value="sold" <?= ($filters['status'] ?? '') === 'sold' ? 'selected' : '' ?>>
            <?= lang('Property.status.sold') ?>
        </option>
    </select>
    <button type="submit" class="btn btn-outline-secondary">Filter</button>
    <a href="/admin/properties" class="btn btn-outline-secondary">Reset</a>
</form>

<?php if (session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card admin-card">
    <div class="card-body">
        <?php if (empty($properties)): ?>
            <p class="text-muted text-center py-4"><?= lang('Property.messages.no_properties') ?></p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th><?= lang('Property.fields.title') ?></th>
                            <th><?= lang('Property.fields.city') ?></th>
                            <th><?= lang('Property.fields.price') ?></th>
                            <th><?= lang('Property.fields.status') ?></th>
                            <th><?= lang('Property.fields.featured') ?></th>
                            <th class="text-end"><?= lang('Property.admin.actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($properties as $property): ?>
                            <tr>
                                <td><?= esc($property->id) ?></td>
                                <td>
                                    <img src="<?= esc($property->getMainImage()) ?>" alt="<?= esc($property->title) ?>"
                                        style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                                </td>
                                <td>
                                    <a href="/admin/properties/<?= esc($property->id) ?>">
                                        <?= esc($property->title) ?>
                                    </a>
                                </td>
                                <td><?= esc($property->city) ?></td>
                                <td><?= format_price($property->price) ?></td>
                                <td><?= property_status_badge($property->status) ?></td>
                                <td>
                                    <?php if ($property->featured): ?>
                                        <span class="badge bg-warning text-dark">Featured</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="/admin/properties/<?= esc($property->id) ?>"
                                            class="btn btn-sm btn-outline-secondary btn-action"
                                            title="<?= lang('Property.admin.view') ?>">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/admin/properties/<?= esc($property->id) ?>/edit"
                                            class="btn btn-sm btn-outline-primary btn-action"
                                            title="<?= lang('Property.admin.edit') ?>">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="/admin/properties/<?= esc($property->id) ?>/delete" method="post"
                                            class="d-inline"
                                            onsubmit="return confirm('<?= lang('Property.messages.confirm_delete') ?>');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action"
                                                title="<?= lang('Property.admin.delete') ?>">
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
