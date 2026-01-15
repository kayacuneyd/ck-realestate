<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <h1>OpenImmo Import Logs</h1>
        <p class="text-muted mb-0">Monitor automated property imports from Propstack CRM</p>
    </div>
    <div>
        <form action="/admin/import/trigger" method="post" class="d-inline">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-arrow-clockwise me-1"></i> Trigger Import
            </button>
        </form>
    </div>
</div>

<!-- Status Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card admin-card">
            <div class="card-body text-center">
                <h3 class="mb-1"><?= $pendingCount ?></h3>
                <p class="text-muted mb-0">Pending Files</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card admin-card">
            <div class="card-body text-center">
                <h3 class="mb-1"><?= $processedCount ?></h3>
                <p class="text-muted mb-0">Processed Files</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card admin-card">
            <div class="card-body text-center">
                <code class="small"><?= esc($importDir) ?></code>
                <p class="text-muted mb-0 mt-1">Import Directory</p>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($pendingFiles)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Pending files:</strong>
        <?= implode(', ', array_map('esc', $pendingFiles)) ?>
    </div>
<?php endif; ?>

<!-- Recent Logs -->
<div class="card admin-card">
    <div class="card-header">
        <i class="bi bi-journal-text me-2"></i> Recent Import Logs
    </div>
    <div class="card-body p-0">
        <?php if (empty($logs)): ?>
            <div class="p-4 text-center text-muted">
                <i class="bi bi-inbox display-4"></i>
                <p class="mt-2">No import logs yet</p>
                <p class="small">
                    Upload a ZIP file to <code><?= esc($importDir) ?></code> to start importing.
                </p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Log Entry</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td>
                                    <code class="small"><?= esc($log) ?></code>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Setup Instructions -->
<div class="card admin-card mt-4">
    <div class="card-header">
        <i class="bi bi-gear me-2"></i> Setup Instructions
    </div>
    <div class="card-body">
        <h6>1. FTP Setup</h6>
        <p class="small text-muted">
            Create an FTP user with access to: <code><?= esc($importDir) ?></code>
        </p>

        <h6>2. Propstack Configuration</h6>
        <p class="small text-muted">
            In Propstack: Verwaltung → Portale → Add Custom Portal with your FTP credentials.
        </p>

        <h6>3. CRON Job (Recommended)</h6>
        <pre
            class="bg-light p-2 rounded small">*/15 * * * * curl -s <?= base_url('openimmo/process') ?> > /dev/null 2>&1</pre>

        <h6>4. Manual Testing</h6>
        <p class="small text-muted">
            Check status: <a href="/openimmo/status" target="_blank">/openimmo/status</a>
        </p>
    </div>
</div>

<?= $this->endSection() ?>