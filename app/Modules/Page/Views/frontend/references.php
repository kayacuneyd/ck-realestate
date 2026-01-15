<?= $this->extend('App\Views\layouts\frontend') ?>

<?= $this->section('content') ?>

<?= view('App\Views\components\page_header', [
    'title' => content('references', 'page_title', 'Referenzen'),
    'subtitle' => content('references', 'page_subtitle', 'Was unsere Kunden über uns sagen'),
    'breadcrumb' => [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Referenzen']
    ]
]) ?>

<div class="container py-5">
    <!-- Stats Section -->
    <div class="row text-center mb-5">
        <div class="col-md-3 mb-4">
            <div class="stat-card p-4">
                <h2 class="fw-bold text-primary mb-1"><?= esc(content('references', 'stat1_value', '500+')) ?></h2>
                <p class="text-muted mb-0"><?= esc(content('references', 'stat1_label', 'Erfolgreiche Verkäufe')) ?></p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card p-4">
                <h2 class="fw-bold text-primary mb-1"><?= esc(content('references', 'stat2_value', '15+')) ?></h2>
                <p class="text-muted mb-0"><?= esc(content('references', 'stat2_label', 'Jahre Erfahrung')) ?></p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card p-4">
                <h2 class="fw-bold text-primary mb-1"><?= esc(content('references', 'stat3_value', '4.9/5')) ?></h2>
                <p class="text-muted mb-0"><?= esc(content('references', 'stat3_label', 'Kundenbewertung')) ?></p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card p-4">
                <h2 class="fw-bold text-primary mb-1"><?= esc(content('references', 'stat4_value', '98%')) ?></h2>
                <p class="text-muted mb-0"><?= esc(content('references', 'stat4_label', 'Weiterempfehlung')) ?></p>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold"><?= esc(content('references', 'testimonials_title', 'Kundenstimmen')) ?></h2>
            <p class="text-muted">
                <?= esc(content('references', 'testimonials_subtitle', 'Echte Erfahrungen unserer zufriedenen Kunden')) ?>
            </p>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="row gx-5 py-5">
        <?php for ($i = 1; $i <= 3; $i++): ?>
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <div class="card-body p-4">
                        <div class="d-flex mb-3">
                            <div class="text-primary fw-bold mb-0">★★★★★</div>
                        </div>
                        <p class="card-text mb-4">
                            "<?= esc(content('references', "testimonial{$i}_text", 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')) ?>"
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="icon-stack bg-primary-soft text-primary me-3 flex-shrink-0">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <div class="fw-bold">
                                    <?= esc(content('references', "testimonial{$i}_author", 'Kunde Name')) ?></div>
                                <div class="text-muted small">
                                    <?= esc(content('references', "testimonial{$i}_detail", 'Transaktion')) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <!-- CTA -->
    <div class="row justify-content-center mt-5 pt-4">
        <div class="col-lg-8 text-center">
            <h3 class="fw-bold mb-3">Werden Sie unser nächster zufriedener Kunde</h3>
            <p class="text-muted mb-4">Lassen Sie uns Ihre Immobiliengeschichte zum Erfolg führen.</p>
            <a href="/contact" class="btn btn-primary btn-lg">Jetzt Kontakt aufnehmen</a>
        </div>
    </div>
</div>

<style>
    .stat-card {
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
    }

    .testimonial-card {
        background: var(--surface);
        padding: 2rem;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
    }

    .testimonial-text {
        font-style: italic;
        color: var(--text);
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .author-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }
</style>

<?= $this->endSection() ?>