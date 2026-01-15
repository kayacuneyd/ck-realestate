<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <h1>Site Settings</h1>
        <p class="text-muted mb-0">Manage your website appearance and configuration</p>
    </div>
</div>

<?php if (session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>
        <?= session('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-circle me-2"></i>
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form action="/admin/settings" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- Logo Settings -->
    <div class="card admin-card mb-4">
        <div class="card-header">
            <i class="bi bi-badge-tm me-2"></i> Logo
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Site Logo</label>

                        <?php if (!empty($settings['site_logo'])): ?>
                            <div class="mb-3 p-3 bg-light rounded">
                                <div class="position-relative d-inline-block">
                                    <img src="<?= esc($settings['site_logo']) ?>" alt="Current Logo" class="img-thumbnail"
                                        style="max-height: 75px; background: #000; padding: 10px;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                        onclick="document.getElementById('removeLogo').value = '1'; this.closest('.mb-3').style.display = 'none';">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="remove_logo" id="removeLogo" value="0">
                                <div class="small text-muted mt-2">Current logo</div>
                            </div>
                        <?php endif; ?>

                        <input type="file" class="form-control" name="site_logo"
                            accept="image/jpeg,image/png,image/svg+xml,image/webp">
                        <div class="form-text">
                            Upload your site logo. Recommended: PNG or SVG with transparent background.
                            Max file size: 2MB.
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title"><i class="bi bi-info-circle me-1"></i> Logo Tips</h6>
                            <ul class="small mb-0">
                                <li>Use transparent PNG or SVG</li>
                                <li>Recommended height: 40-60px</li>
                                <li>Dark logo works best on light navbar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section Settings -->
    <div class="card admin-card mb-4">
        <div class="card-header">
            <i class="bi bi-image me-2"></i> Hero Section
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label class="form-label">Background Image</label>

                        <?php if (!empty($settings['hero_background_image'])): ?>
                            <div class="mb-3 p-3 bg-light rounded">
                                <div class="position-relative d-inline-block">
                                    <img src="<?= esc($settings['hero_background_image']) ?>" alt="Current Hero Background"
                                        class="img-thumbnail" style="max-height: 200px; max-width: 100%;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                        onclick="document.getElementById('removeHeroImage').value = '1'; this.closest('.mb-3').style.display = 'none';">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="remove_hero_image" id="removeHeroImage" value="0">
                                <div class="small text-muted mt-2">Current background image</div>
                            </div>
                        <?php endif; ?>

                        <input type="file" class="form-control" name="hero_background_image"
                            accept="image/jpeg,image/png,image/webp">
                        <div class="form-text">
                            Upload a background image for the homepage hero section.
                            Recommended size: 1920x1080px. Max file size: 5MB.
                            Supported formats: JPG, PNG, WebP.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Overlay Opacity</label>
                        <input type="range" class="form-range" name="hero_overlay_opacity" id="overlayOpacity" min="0"
                            max="1" step="0.1" value="<?= esc($settings['hero_overlay_opacity'] ?? '0.5') ?>"
                            onchange="document.getElementById('opacityValue').textContent = this.value">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Lighter</small>
                            <small class="text-muted">
                                Current: <span
                                    id="opacityValue"><?= esc($settings['hero_overlay_opacity'] ?? '0.5') ?></span>
                            </small>
                            <small class="text-muted">Darker</small>
                        </div>
                        <div class="form-text">
                            Adjust the darkness of the overlay to improve text readability.
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title"><i class="bi bi-info-circle me-1"></i> Tips</h6>
                            <ul class="small mb-0">
                                <li>Use high-quality images for best results</li>
                                <li>Dark images work better with white text</li>
                                <li>Increase overlay opacity if text is hard to read</li>
                                <li>Real estate or cityscape images work well</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i> Save Settings
        </button>
        <a href="/admin/dashboard" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<?= $this->endSection() ?>
