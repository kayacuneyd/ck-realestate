<footer class="pt-5 pb-4">
    <div class="container">
        <div class="row">
            <!-- Brand and Socials -->
            <div class="col-md-3 mb-4">
                <h5><?= esc(content('settings', 'company_name', 'Bawue Immobilien')) ?></h5>
                <p><?= esc(content('footer', 'brand_description', 'Ihr vertrauenswürdiger Partner bei der Suche nach dem perfekten Zuhause. Wir stehen für Exzellenz und Transparenz.')) ?>
                </p>
                <div>
                    <a href="<?= esc(content('settings', 'social_facebook', '#')) ?>" class="me-2"><i
                            class="bi bi-facebook"></i></a>
                    <a href="<?= esc(content('settings', 'social_instagram', '#')) ?>" class="me-2"><i
                            class="bi bi-instagram"></i></a>
                    <a href="<?= esc(content('settings', 'social_linkedin', '#')) ?>"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3 mb-4">
                <h5>Navigation</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="text-decoration-none">Home</a></li>
                    <li><a href="/properties" class="text-decoration-none">Immobilien</a></li>
                    <li><a href="/how-it-works" class="text-decoration-none">Wie es funktioniert</a></li>
                    <li><a href="/references" class="text-decoration-none">Referenzen</a></li>
                    <li><a href="/about" class="text-decoration-none">Über uns</a></li>
                    <li><a href="/contact" class="text-decoration-none">Kontakt</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-3 mb-4">
                <h5>Kontakt</h5>
                <ul class="list-unstyled">
                    <li><i
                            class="bi bi-geo-alt-fill me-2"></i><?= esc(content('settings', 'company_address', 'Musterstraße 123, 70173 Stuttgart')) ?>
                    </li>
                    <li><i
                            class="bi bi-telephone-fill me-2"></i><?= esc(content('settings', 'company_phone', '+49 711 123 456 78')) ?>
                    </li>
                    <li><i
                            class="bi bi-envelope-fill me-2"></i><?= esc(content('settings', 'company_email', 'info@bawue-immobilien.de')) ?>
                    </li>
                    <li><i
                            class="bi bi-clock-fill me-2"></i><?= esc(content('settings', 'company_hours', 'Mo - Fr: 9:00 - 18:00 Uhr')) ?>
                    </li>
                </ul>
            </div>

            <!-- Trust Signals -->
            <div class="col-md-3 mb-4">
                <h5>Warum wir?</h5>
                <ul class="list-unstyled">
                    <li><i
                            class="bi bi-trophy-fill me-2"></i><?= esc(content('footer', 'stat1', '15+ Jahre Erfahrung')) ?>
                    </li>
                    <li><i
                            class="bi bi-check-circle-fill me-2"></i><?= esc(content('footer', 'stat2', '500+ Erfolgreiche Verkäufe')) ?>
                    </li>
                    <li><i
                            class="bi bi-star-fill me-2"></i><?= esc(content('footer', 'stat3', '4.9/5 Kundenbewertung')) ?>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Section: Two Column Layout -->
        <hr class="my-4 opacity-25">
        <div class="row align-items-center small">
            <!-- Left Column: Copyright & Credits -->
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-0">
                    Entwickelt von <a href="https://kayacuneyt.com" target="_blank" rel="noopener">Cüneyt Kaya</a> &
                    <a href="https://digitaltamam.com" target="_blank" rel="noopener">digitaltamam.com</a>
                    &copy; 2026 Bawue Immobilien. Alle Rechte vorbehalten.
                </p>
            </div>

            <!-- Right Column: Legal Links -->
            <div class="col-md-6 text-center text-md-end">
                <a href="/imprint" class="text-decoration-none me-3">Impressum</a>
                <a href="/datenschutz" class="text-decoration-none">Datenschutz</a>
            </div>
        </div>
    </div>
</footer>