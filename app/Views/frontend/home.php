<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

    <?= view('components/page_header', [
        'title' => lang('Home.hero_title'),
        'subtitle' => lang('Home.hero_subtitle'),
        'class' => 'hero',
        'actions' => '<a class="btn btn-primary btn-lg px-4 me-sm-3" href="/properties">' . lang('Home.hero_button_listings') . '</a>'
            . '<a class="btn btn-outline-light btn-lg px-4" href="/contact">' . lang('Home.hero_button_valuation') . '</a>',
    ]) ?>

    <!-- Trust Signals Section -->
    <section class="py-5">
        <div class="container px-5">
            <div class="row gx-5 text-center">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="icon-stack icon-stack-xl bg-primary text-white mb-3">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h3>15+</h3>
                    <p class="lead"><?= lang('Home.trust_years') ?></p>
                </div>
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="icon-stack icon-stack-xl bg-primary text-white mb-3">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h3>500+</h3>
                    <p class="lead"><?= lang('Home.trust_closings') ?></p>
                </div>
                <div class="col-lg-4">
                    <div class="icon-stack icon-stack-xl bg-primary text-white mb-3">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h3>4.9/5</h3>
                    <p class="lead"><?= lang('Home.trust_rating') ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5 bg-light">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bolder"><?= lang('Home.services_title') ?></h2>
                    <p class="lead mb-5"><?= lang('Home.services_subtitle') ?></p>
                </div>
            </div>
            <div class="row gx-5">
                <div class="col-lg-4 mb-5">
                    <div class="card h-100 shadow border-0">
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2"><?= lang('Home.service_buying_title') ?></div>
                            <p><?= lang('Home.service_buying_text') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="card h-100 shadow border-0">
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2"><?= lang('Home.service_selling_title') ?></div>
                            <p><?= lang('Home.service_selling_text') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="card h-100 shadow border-0">
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2"><?= lang('Home.service_rentals_title') ?></div>
                            <p><?= lang('Home.service_rentals_text') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Listings -->
    <section class="py-5">
        <div class="container px-5">
            <h2 class="fw-bolder text-center mb-5"><?= lang('Home.featured_title') ?></h2>
            <div class="row gx-5">
                <!-- Placeholder Card 1 -->
                <div class="col-lg-4 mb-5">
                    <div class="card h-100 shadow border-0">
                        <img class="card-img-top" src="/assets/images/placeholder-card.svg" alt="Featured Property 1" />
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2"><?= lang('Home.badge_for_sale') ?></div>
                            <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3"><?= lang('Home.featured_placeholder_1_title') ?></h5></a>
                            <p class="card-text mb-0"><?= lang('Home.featured_placeholder_1_text') ?></p>
                        </div>
                    </div>
                </div>
                <!-- Placeholder Card 2 -->
                <div class="col-lg-4 mb-5">
                    <div class="card h-100 shadow border-0">
                        <img class="card-img-top" src="/assets/images/placeholder-card.svg" alt="Featured Property 2" />
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2"><?= lang('Home.badge_for_rent') ?></div>
                            <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3"><?= lang('Home.featured_placeholder_2_title') ?></h5></a>
                            <p class="card-text mb-0"><?= lang('Home.featured_placeholder_2_text') ?></p>
                        </div>
                    </div>
                </div>
                <!-- Placeholder Card 3 -->
                <div class="col-lg-4 mb-5">
                    <div class="card h-100 shadow border-0">
                        <img class="card-img-top" src="/assets/images/placeholder-card.svg" alt="Featured Property 3" />
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2"><?= lang('Home.badge_for_sale') ?></div>
                            <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3"><?= lang('Home.featured_placeholder_3_title') ?></h5></a>
                            <p class="card-text mb-0"><?= lang('Home.featured_placeholder_3_text') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container px-5">
            <h2 class="fw-bolder text-center mb-5"><?= lang('Home.testimonials_title') ?></h2>
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p class="lead"><?= lang('Home.testimonial_1_text') ?></p>
                            <div class="d-flex align-items-center">
                            <img class="rounded-circle me-3" src="/assets/images/placeholder-avatar.svg"
                                alt="Client Testimonial" style="width: 150px; height: 150px; object-fit: cover;" />
                                <div class="small">
                                    <div class="fw-bold"><?= lang('Home.testimonial_1_author') ?></div>
                                    <div class="text-muted"><?= lang('Home.testimonial_1_author_title') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
