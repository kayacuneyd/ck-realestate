<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4"><?= esc($page->title) ?></h1>
            <div>
                <?= $page->content ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
