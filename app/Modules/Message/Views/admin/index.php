<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <h1>Messages</h1>
        <p class="text-muted mb-0">
            <?php if ($unreadCount > 0): ?>
                <span class="badge bg-danger"><?= $unreadCount ?></span> unread message<?= $unreadCount > 1 ? 's' : '' ?>
            <?php else: ?>
                All messages read
            <?php endif; ?>
        </p>
    </div>
</div>

<?php if (session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show">
        <?= session('warning') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Filter Tabs -->
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link <?= !$currentFilter ? 'active' : '' ?>" href="/admin/messages">All</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $currentFilter === 'unread' ? 'active' : '' ?>" href="/admin/messages?status=unread">
            Unread
            <?php if ($unreadCount > 0): ?>
                <span class="badge bg-danger"><?= $unreadCount ?></span>
            <?php endif; ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $currentFilter === 'read' ? 'active' : '' ?>" href="/admin/messages?status=read">Read</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $currentFilter === 'replied' ? 'active' : '' ?>"
            href="/admin/messages?status=replied">Replied</a>
    </li>
</ul>

<div class="card admin-card">
    <div class="card-body p-0">
        <?php if (empty($messages)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-envelope-open" style="font-size: 3rem;"></i>
                <p class="mt-3">No messages found.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr class="<?= $msg->isUnread() ? 'table-light fw-bold' : '' ?>">
                                <td class="text-center">
                                    <?php if ($msg->isUnread()): ?>
                                        <i class="bi bi-circle-fill text-primary" style="font-size: 0.5rem;"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div><?= esc($msg->name) ?></div>
                                    <small class="text-muted fw-normal"><?= esc($msg->email) ?></small>
                                </td>
                                <td>
                                    <a href="/admin/messages/<?= $msg->id ?>" class="text-decoration-none">
                                        <?= esc($msg->subject ?: 'No subject') ?>
                                    </a>
                                    <div class="text-muted small fw-normal"
                                        style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <?= esc(substr($msg->message, 0, 60)) ?>...
                                    </div>
                                </td>
                                <td class="fw-normal">
                                    <small><?= $msg->created_at->humanize() ?></small>
                                </td>
                                <td>
                                    <span class="badge <?= $msg->getStatusBadgeClass() ?>">
                                        <?= $msg->getStatusLabel() ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/admin/messages/<?= $msg->id ?>" class="btn btn-sm btn-outline-primary"
                                        title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="/admin/messages/<?= $msg->id ?>/delete" method="post" class="d-inline"
                                        onsubmit="return confirm('Delete this message?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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