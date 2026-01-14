<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<?= view('components/page_header', [
    'title' => 'Meet Our Expert Agents',
    'subtitle' => 'Dedicated professionals ready to help you find your perfect property.',
]) ?>

<div class="container py-5">

    <div class="row g-4">
        <?php if (!empty($agents)): ?>
            <?php foreach ($agents as $agent): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 text-center shadow-sm border-0">
                        <div class="card-body">
                            <?php $photo = image_fallback($agent->photo ?? '', '/assets/images/placeholder-avatar.svg'); ?>
                            <img src="<?= esc($photo) ?>" class="rounded-circle mb-3" alt="<?= esc($agent->name) ?>"
                                style="width: 150px; height: 150px; object-fit: cover;">
                            <h5 class="card-title"><?= esc($agent->name) ?></h5>
                            <p class="card-text text-muted"><?= esc($agent->title) ?></p>
                            <div class="mt-3">
                                <a href="#" class="text-secondary me-2"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="text-secondary me-2"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="text-secondary"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-3">
                             <a href="#" class="btn btn-primary">View Profile</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col">
                <p class="text-center">No agents found at this time.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
