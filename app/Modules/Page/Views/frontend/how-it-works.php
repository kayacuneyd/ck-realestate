<?= $this->extend('App\Views\layouts\frontend') ?>

<?= $this->section('content') ?>

<?= view('App\Views\components\page_header', [
    'title' => content('how-it-works', 'page_title', 'Wie es funktioniert'),
    'subtitle' => content('how-it-works', 'page_subtitle', 'Der Weg zu Ihrem erfolgreichen Immobilienverkauf'),
    'breadcrumb' => [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Wie es funktioniert']
    ]
]) ?>

<div class="container py-5">
    <!-- Timeline Steps -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h2 class="fw-bold">
                    <?= esc(content('how-it-works', 'section_title', 'Ihr Immobilienverkauf in 5 einfachen Schritten')) ?>
                </h2>
                <p class="text-muted">
                    <?= esc(content('how-it-works', 'section_subtitle', 'Transparent, professionell und stressfrei')) ?>
                </p>
            </div>

            <div class="process-timeline">
                <!-- Step 1 -->
                <div class="process-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4><?= esc(content('how-it-works', 'step1_title', 'Kostenlose Erstberatung')) ?></h4>
                        <p><?= esc(content('how-it-works', 'step1_text', 'Kontaktieren Sie uns für ein unverbindliches Gespräch.')) ?>
                        </p>
                        <ul class="step-checklist">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unverbindlich und kostenlos
                            </li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Persönlich oder telefonisch
                            </li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Erste Markteinschätzung</li>
                        </ul>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="process-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4><?= esc(content('how-it-works', 'step2_title', 'Professionelle Immobilienbewertung')) ?>
                        </h4>
                        <p><?= esc(content('how-it-works', 'step2_text', 'Wir führen eine detaillierte Analyse Ihrer Immobilie durch.')) ?>
                        </p>
                        <ul class="step-checklist">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Vor-Ort-Besichtigung</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Marktanalyse und
                                Vergleichsobjekte</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Schriftliches Wertgutachten
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="process-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4><?= esc(content('how-it-works', 'step3_title', 'Professionelle Vermarktung')) ?></h4>
                        <p><?= esc(content('how-it-works', 'step3_text', 'Wir erstellen hochwertige Fotos und ansprechende Exposés.')) ?>
                        </p>
                        <ul class="step-checklist">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Professionelle Fotografie</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Exposé-Erstellung</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Anzeigen auf ImmoScout24,
                                Immowelt & Co.</li>
                        </ul>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="process-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h4><?= esc(content('how-it-works', 'step4_title', 'Besichtigungen & Verhandlungen')) ?></h4>
                        <p><?= esc(content('how-it-works', 'step4_text', 'Wir koordinieren alle Besichtigungstermine.')) ?>
                        </p>
                        <ul class="step-checklist">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Qualifizierte
                                Interessentenauswahl</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Professionelle
                                Besichtigungstermine</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Preisverhandlungen für Sie</li>
                        </ul>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="process-step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h4><?= esc(content('how-it-works', 'step5_title', 'Notartermin & Übergabe')) ?></h4>
                        <p><?= esc(content('how-it-works', 'step5_text', 'Wir begleiten Sie bis zum erfolgreichen Abschluss.')) ?>
                        </p>
                        <ul class="step-checklist">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Kaufvertragsvorbereitung</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Notartermin-Begleitung</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Schlüsselübergabe</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8 text-center">
            <div class="cta-box p-5 rounded-4">
                <h3 class="fw-bold mb-3">
                    <?= esc(content('how-it-works', 'cta_title', 'Bereit für den nächsten Schritt?')) ?></h3>
                <p class="mb-4">
                    <?= esc(content('how-it-works', 'cta_text', 'Kontaktieren Sie uns noch heute für Ihre kostenlose Erstberatung.')) ?>
                </p>
                <a href="/contact"
                    class="btn btn-primary btn-lg"><?= esc(content('how-it-works', 'cta_button', 'Kostenlose Beratung anfragen')) ?></a>
            </div>
        </div>
    </div>
</div>

<style>
    .process-timeline {
        position: relative;
        padding-left: 80px;
    }

    .process-timeline::before {
        content: '';
        position: absolute;
        left: 25px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, var(--primary) 0%, var(--accent) 100%);
    }

    .process-step {
        position: relative;
        margin-bottom: 3rem;
        padding: 2rem;
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
    }

    .step-number {
        position: absolute;
        left: -55px;
        top: 2rem;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }

    .step-content h4 {
        color: var(--text);
        margin-bottom: 1rem;
    }

    .step-content p {
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .step-checklist {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .step-checklist li {
        padding: 0.25rem 0;
        color: var(--text);
    }

    .cta-box {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
    }

    .cta-box h3,
    .cta-box p {
        color: white;
    }

    @media (max-width: 768px) {
        .process-timeline {
            padding-left: 50px;
        }

        .process-timeline::before {
            left: 15px;
        }

        .step-number {
            left: -35px;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }
</style>

<?= $this->endSection() ?>