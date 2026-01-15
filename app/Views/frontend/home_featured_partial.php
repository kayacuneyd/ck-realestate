<!-- Featured Listings Section -->
<section class="py-5" id="featured-properties">
    <div class="container px-5">
        <h2 class="fw-bolder text-center mb-5"><?= lang('Home.featured_title') ?></h2>
        <div class="row gx-5">
            <?php if (!empty($featuredProperties)): ?>
                <?php foreach ($featuredProperties as $property): ?>
                    <div class="col-lg-4 mb-5">
                        <div class="card h-100 shadow border-0">
                            <div class="position-relative" style="height: 200px; overflow: hidden;">
                                <img class="card-img-top"
                                    src="<?= !empty($property->main_image_url) ? esc($property->main_image_url) : '/assets/images/placeholder-property.jpg' ?>"
                                    alt="<?= esc($property->title) ?>" style="object-fit: cover; height: 100%; width: 100%;" />
                                <div class="badge bg-primary bg-gradient rounded-pill position-absolute top-0 end-0 m-3">
                                    <?= esc($property->type) ?></div>
                            </div>
                            <div class="card-body p-4">
                                <div class="badge bg-light text-primary mb-2"><?= esc($property->city) ?></div>
                                <a class="text-decoration-none link-dark stretched-link"
                                    href="/properties/<?= esc($property->slug) ?>">
                                    <h5 class="card-title mb-3"><?= esc($property->title) ?></h5>
                                </a>
                                <p class="card-text mb-0 text-truncate"><?= esc(strip_tags($property->description)) ?></p>
                                <div class="mt-3 fw-bold text-primary">
                                    <?= number_format($property->price, 0, ',', '.') ?> €
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Momentan sind keine Immobilien hervorgehoben.</p>
                    <a href="/properties" class="btn btn-outline-primary">Alle Immobilien ansehen</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>