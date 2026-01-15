<?= $this->extend('App\Views\layouts\frontend') ?>

<?= $this->section('content') ?>

<?= view('App\Views\components\page_header', [
    'title' => content('home', 'hero_title', 'Finden Sie Ihr Traumhaus noch heute'),
    'subtitle' => content('home', 'hero_subtitle', 'Ihr vertrauenswürdiger Partner für erstklassige Immobilien in Baden-Württemberg'),
    'class' => 'hero',
    'actions' => '<a class="btn btn-primary btn-lg px-4 me-sm-3" href="/properties">' . content('home', 'hero_button_listings', 'Aktuelle Angebote') . '</a>'
        . '<a class="btn btn-outline-light btn-lg px-4" href="/contact">' . content('home', 'hero_button_valuation', 'Kostenlose Bewertung') . '</a>',
]) ?>

<!-- Trust Signals Section -->
<section class="py-5">
    <div class="container px-5">
        <div class="row gx-5 text-center">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="icon-stack icon-stack-xl bg-primary text-white mb-3">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <h3><?= esc(content('home', 'trust_years_value', '15+')) ?></h3>
                <p class="lead"><?= esc(content('home', 'trust_years_label', 'Jahre Erfahrung')) ?></p>
            </div>
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="icon-stack icon-stack-xl bg-primary text-white mb-3">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h3><?= esc(content('home', 'trust_closings_value', '500+')) ?></h3>
                <p class="lead"><?= esc(content('home', 'trust_closings_label', 'Erfolgreiche Verkäufe')) ?></p>
            </div>
            <div class="col-lg-4">
                <div class="icon-stack icon-stack-xl bg-primary text-white mb-3">
                    <i class="bi bi-star-fill"></i>
                </div>
                <h3><?= esc(content('home', 'trust_rating_value', '4.9/5')) ?></h3>
                <p class="lead"><?= esc(content('home', 'trust_rating_label', 'Kundenbewertung')) ?></p>
            </div>
        </div>
    </div>
</section>

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
                                <img class="card-img-top" src="<?= esc($property->getMainImage()) ?>"
                                    alt="<?= esc($property->title) ?>" style="object-fit: cover; height: 100%; width: 100%;" />
                                <div class="badge bg-primary bg-gradient rounded-pill position-absolute top-0 end-0 m-3">
                                    <?= esc($property->type) ?>
                                </div>
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

<!-- Services Section -->
<section class="py-5 bg-light">
    <div class="container px-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bolder"><?= esc(content('home', 'services_title', 'Unsere Leistungen')) ?></h2>
                <p class="lead mb-5">
                    <?= esc(content('home', 'services_subtitle', 'Wir bieten Ihnen einen umfassenden Service rund um Ihre Immobilie')) ?>
                </p>
            </div>
        </div>
        <div class="row gx-5">
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <div class="card-body p-4">
                        <div class="badge bg-primary bg-gradient rounded-pill mb-2">Kaufen</div>
                        <p>Finden Sie Ihre Traumimmobilie in unserem exklusiven Portfolio.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <div class="card-body p-4">
                        <div class="badge bg-primary bg-gradient rounded-pill mb-2">Verkaufen</div>
                        <p>Wir verkaufen Ihre Immobilie zum bestmöglichen Preis.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <div class="card-body p-4">
                        <div class="badge bg-primary bg-gradient rounded-pill mb-2">Vermieten</div>
                        <p>Professionelle Vermietung und Verwaltung Ihrer Immobilien.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="text-center">
                    <h2 class="fw-bolder"><?= esc(content('home', 'cta_title', 'Bereit für den nächsten Schritt?')) ?>
                    </h2>
                    <p class="lead fw-normal text-muted mb-5">
                        <?= esc(content('home', 'cta_subtitle', 'Kontaktieren Sie uns für eine kostenlose Beratung')) ?>
                    </p>
                    <a class="btn btn-primary btn-lg"
                        href="/contact"><?= esc(content('home', 'cta_button', 'Kostenlose Beratung anfragen')) ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>