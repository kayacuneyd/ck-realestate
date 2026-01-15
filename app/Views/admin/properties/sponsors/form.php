<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= esc($title) ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/admin/sponsors" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Geri Dön
        </a>
    </div>
</div>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <form
                    action="<?= isset($sponsor) ? '/admin/sponsors/update/' . $sponsor['id'] : '/admin/sponsors/store' ?>"
                    method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Sponsor İsmi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?= old('name', $sponsor['name'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="logo_url" class="form-label">Logo URL <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="logo_url" name="logo_url"
                                value="<?= old('logo_url', $sponsor['logo_url'] ?? '') ?>" required>
                            <button class="btn btn-outline-secondary" type="button" id="browseButton">Dosya Seç</button>
                        </div>
                        <div class="form-text">Tam URL veya /uploads/ klasörü yolu.</div>
                    </div>

                    <div class="mb-3">
                        <label for="website_url" class="form-label">Web Sitesi URL</label>
                        <input type="url" class="form-control" id="website_url" name="website_url"
                            value="<?= old('website_url', $sponsor['website_url'] ?? '') ?>" placeholder="https://...">
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sıralama</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order"
                            value="<?= old('sort_order', $sponsor['sort_order'] ?? 0) ?>">
                        <div class="form-text">Düşük rakamlar önce gösterilir.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Simple File Browser Script stub (can be enhanced) -->
<script>
    document.getElementById('browseButton').addEventListener('click', function () {
        // Ideally this would open a file manager. For now, prompt context.
        alert('Resim dosya yolunu "settings" sayfasındaki gibi manuel giriniz veya medya yöneticisi entegre edilmelidir.');
    });
</script>

<?= $this->endSection() ?>