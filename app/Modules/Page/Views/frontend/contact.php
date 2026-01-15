<?= $this->extend('App\Views\layouts\frontend') ?>

<?= $this->section('content') ?>

<?= view('App\Views\components\page_header', [
    'title' => content('contact', 'page_title', 'Get in Touch'),
    'subtitle' => content('contact', 'page_subtitle', "We'd love to hear from you. Contact us for any inquiries or to schedule a free valuation."),
]) ?>

<!-- Contact section-->
<section class="py-5">
    <div class="container px-5">
        <style>
            .contact-feature {
                background: #004aad;
                color: #f8f9fa;
                padding: 16px;
                min-height: 110px;
                transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
            }

            .contact-feature-title {
                color: #f8f9fa;
            }

            .contact-feature:hover {
                background-color: rgba(0, 74, 173, 0.9);
                box-shadow: 0 10px 24px rgba(0, 0, 0, 0.2);
                transform: translateY(-3px);
            }

            @media (max-width: 575.98px) {
                .contact-form-wrapper {
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                }
            }
        </style>
        <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5 contact-form-wrapper">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="text-center mb-5">
                        <h3><?= esc(content('contact', 'form_title', 'Schreiben Sie uns')) ?></h3>
                        <p class="text-muted">
                            <?= esc(content('contact', 'form_subtitle', 'Füllen Sie das Formular aus und wir melden uns schnellstmöglich bei Ihnen.')) ?>
                        </p>
                    </div>

                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>
                            <?= session('success') ?>
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

                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="/contact/send" method="post">
                        <?= csrf_field() ?>
                        <!-- Name input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" name="name" type="text"
                                placeholder="Enter your name..." value="<?= old('name') ?>" required />
                            <label for="name">Full name</label>
                        </div>
                        <!-- Email address input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="email" name="email" type="email"
                                placeholder="name@example.com" value="<?= old('email') ?>" required />
                            <label for="email">Email address</label>
                        </div>
                        <!-- Phone number input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="phone" name="phone" type="tel" placeholder="(123) 456-7890"
                                value="<?= old('phone') ?>" />
                            <label for="phone">Phone number</label>
                        </div>
                        <!-- Subject input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="subject" name="subject" type="text" placeholder="Subject"
                                value="<?= old('subject') ?>" />
                            <label for="subject">Subject</label>
                        </div>
                        <!-- Message input-->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="message" name="message"
                                placeholder="Enter your message here..." style="height: 10rem"
                                required><?= old('message') ?></textarea>
                            <label for="message">Message</label>
                        </div>
                        <!-- Submit Button-->
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="bi bi-send me-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact cards with dynamic content -->
        <div class="row gx-5 row-cols-1 row-cols-lg-4 py-5">
            <div class="col">
                <div
                    class="feature contact-feature rounded-3 mb-3 d-flex flex-column align-items-center justify-content-center text-center">
                    <i class="bi bi-envelope fs-3"></i>
                    <div class="h6 mb-0 contact-feature-title">E-Mail</div>
                </div>
                <p class="text-muted mb-0 text-center">
                    <?= esc(content('settings', 'company_email', 'info@bawue-immobilien.de')) ?>
                </p>
            </div>
            <div class="col">
                <div
                    class="feature contact-feature rounded-3 mb-3 d-flex flex-column align-items-center justify-content-center text-center">
                    <i class="bi bi-clock fs-3"></i>
                    <div class="h6 mb-0 contact-feature-title">Öffnungszeiten</div>
                </div>
                <p class="text-muted mb-0 text-center">
                    <?= esc(content('settings', 'company_hours', 'Mo - Fr: 9:00 - 18:00 Uhr')) ?>
                </p>
            </div>
            <div class="col">
                <div
                    class="feature contact-feature rounded-3 mb-3 d-flex flex-column align-items-center justify-content-center text-center">
                    <i class="bi bi-geo-alt fs-3"></i>
                    <div class="h6 mb-0 contact-feature-title">Adresse</div>
                </div>
                <p class="text-muted mb-0 text-center">
                    <?= esc(content('settings', 'company_address', 'Musterstraße 123, 70173 Stuttgart')) ?>
                </p>
            </div>
            <div class="col">
                <div
                    class="feature contact-feature rounded-3 mb-3 d-flex flex-column align-items-center justify-content-center text-center">
                    <i class="bi bi-telephone fs-3"></i>
                    <div class="h6 mb-0 contact-feature-title">Telefon</div>
                </div>
                <p class="text-muted mb-0 text-center">
                    <?= esc(content('settings', 'company_phone', '+49 711 123 456 78')) ?></p>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
