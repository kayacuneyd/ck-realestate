<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Message from <?= esc($message->name) ?></h1>
        <p class="text-muted mb-0">
            <span class="badge <?= $message->getStatusBadgeClass() ?>"><?= $message->getStatusLabel() ?></span>
            &bull; Received <?= $message->created_at->humanize() ?>
        </p>
    </div>
    <a href="/admin/messages" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Messages
    </a>
</div>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <!-- Message Content -->
        <div class="card admin-card mb-4">
            <div class="card-header">
                <i class="bi bi-envelope me-2"></i> Message
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">From:</div>
                    <div class="col-sm-9"><strong><?= esc($message->name) ?></strong></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Email:</div>
                    <div class="col-sm-9">
                        <a href="mailto:<?= esc($message->email) ?>"><?= esc($message->email) ?></a>
                    </div>
                </div>
                <?php if ($message->phone): ?>
                    <div class="row mb-3">
                        <div class="col-sm-3 text-muted">Phone:</div>
                        <div class="col-sm-9">
                            <a href="tel:<?= esc($message->phone) ?>"><?= esc($message->phone) ?></a>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Subject:</div>
                    <div class="col-sm-9"><?= esc($message->subject ?: 'No subject') ?></div>
                </div>
                <hr>
                <div class="bg-light rounded p-3" style="white-space: pre-wrap;"><?= esc($message->message) ?></div>
            </div>
        </div>

        <?php if ($message->isReplied()): ?>
            <!-- Previous Reply -->
            <div class="card admin-card border-success mb-4">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-reply me-2"></i> Your Reply
                    <small class="float-end">Sent <?= $message->replied_at->humanize() ?></small>
                </div>
                <div class="card-body">
                    <div class="bg-light rounded p-3" style="white-space: pre-wrap;"><?= esc($message->reply) ?></div>
                </div>
            </div>
        <?php else: ?>
            <!-- Reply Form -->
            <div class="card admin-card">
                <div class="card-header">
                    <i class="bi bi-reply me-2"></i> Send Reply
                </div>
                <div class="card-body">
                    <form action="/admin/messages/<?= $message->id ?>/reply" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="reply" class="form-label">Your Response</label>
                            <textarea class="form-control" id="reply" name="reply" rows="6" required
                                placeholder="Type your response here..."></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i> Send Reply
                            </button>
                            <a href="mailto:<?= esc($message->email) ?>?subject=Re: <?= urlencode($message->subject ?: 'Your inquiry') ?>"
                                class="btn btn-outline-secondary">
                                <i class="bi bi-envelope me-1"></i> Reply via Email Client
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card admin-card">
            <div class="card-header">Quick Actions</div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:<?= esc($message->email) ?>?subject=Re: <?= urlencode($message->subject ?: 'Your inquiry') ?>"
                        class="btn btn-outline-primary">
                        <i class="bi bi-envelope me-2"></i> Email Directly
                    </a>
                    <?php if ($message->phone): ?>
                        <a href="tel:<?= esc($message->phone) ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-telephone me-2"></i> Call
                        </a>
                    <?php endif; ?>
                    <hr>
                    <form action="/admin/messages/<?= $message->id ?>/delete" method="post"
                        onsubmit="return confirm('Are you sure you want to delete this message?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i> Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>