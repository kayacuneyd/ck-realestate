<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<?= view('components/page_header', [
    'title' => $property->title,
    'subtitle' => trim($property->city . ' - ' . format_price($property->price)),
]) ?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">

            <!-- Image Gallery -->
            <div class="mb-4">
                <img src="<?= esc($property->getMainImage()) ?>" class="img-fluid rounded shadow-sm w-100" alt="<?= esc($property->title) ?>">
                <!-- Thumbnails (optional) -->
                <div class="row g-2 mt-2">
                    <div class="col-3"><img src="/assets/images/placeholder-card.svg" class="img-fluid rounded" alt="Thumbnail 1"></div>
                    <div class="col-3"><img src="/assets/images/placeholder-card.svg" class="img-fluid rounded" alt="Thumbnail 2"></div>
                    <div class="col-3"><img src="/assets/images/placeholder-card.svg" class="img-fluid rounded" alt="Thumbnail 3"></div>
                    <div class="col-3"><img src="/assets/images/placeholder-card.svg" class="img-fluid rounded" alt="Thumbnail 4"></div>
                </div>
            </div>

            <!-- Description -->
            <h3 class="mb-3">Description</h3>
            <p><?= nl2br(esc($property->description)) ?></p>

        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="text-primary mb-0">$<?= number_format($property->price) ?></h3>
                        <span class="badge bg-light text-dark fs-6"><?= esc(ucfirst($property->type)) ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-around text-center my-3">
                        <div><i class="bi bi-door-open fs-4"></i><div class="small"><?= esc($property->bedrooms) ?> Beds</div></div>
                        <div><i class="bi bi-droplet fs-4"></i><div class="small"><?= esc($property->bathrooms) ?> Baths</div></div>
                        <div><i class="bi bi-arrows-fullscreen fs-4"></i><div class="small"><?= esc($property->area_sqm) ?> sqm</div></div>
                    </div>
                    <hr>
                    <h5 class="card-title mb-3">Schedule a Viewing</h5>
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your Email">
                        </div>
                         <div class="mb-3">
                            <textarea class="form-control" rows="3" placeholder="I'm interested in this property..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Inquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Properties -->
    <?php if (!empty($related)): ?>
        <hr class="my-5">
        <h3 class="mb-4">Similar Properties</h3>
        <div class="row g-4">
            <?php foreach ($related as $relatedProperty): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?= esc($relatedProperty->getMainImage()) ?>" class="card-img-top"
                            alt="<?= esc($relatedProperty->title) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($relatedProperty->title) ?></h5>
                            <p class="card-text small text-muted"><i class="bi bi-geo-alt-fill me-1"></i><?= esc($relatedProperty->city) ?></p>
                            <h5 class="text-primary">$<?= number_format($relatedProperty->price) ?></h5>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-3">
                             <a href="/properties/<?= esc($relatedProperty->slug) ?>" class="btn btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
