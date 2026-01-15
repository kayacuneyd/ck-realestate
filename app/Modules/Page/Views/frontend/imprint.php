<?= $this->extend('App\Views\layouts\frontend') ?>

<?= $this->section('content') ?>

<?= view('App\Views\components\page_header', [
    'title' => 'Impressum',
    'subtitle' => 'Rechtliche Informationen',
    'breadcrumb' => [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Impressum']
    ]
]) ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="legal-content">
                <h2>Angaben gemäß § 5 TMG</h2>
                <p>
                    <strong>Bawue Immobilien GmbH</strong><br>
                    Musterstraße 123<br>
                    70173 Stuttgart<br>
                    Deutschland
                </p>

                <h3>Vertreten durch</h3>
                <p>Geschäftsführer: Max Mustermann</p>

                <h3>Kontakt</h3>
                <p>
                    Telefon: +49 (0) 711 123 456 78<br>
                    E-Mail: info@bawue-immobilien.de
                </p>

                <h3>Registereintrag</h3>
                <p>
                    Eintragung im Handelsregister<br>
                    Registergericht: Amtsgericht Stuttgart<br>
                    Registernummer: HRB 123456
                </p>

                <h3>Umsatzsteuer-ID</h3>
                <p>
                    Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz:<br>
                    DE 123 456 789
                </p>

                <h3>Aufsichtsbehörde</h3>
                <p>
                    Industrie- und Handelskammer Region Stuttgart<br>
                    Jägerstraße 30<br>
                    70174 Stuttgart
                </p>

                <h3>Berufsbezeichnung und berufsrechtliche Regelungen</h3>
                <p>
                    Berufsbezeichnung: Immobilienmakler<br>
                    Erlaubnis gemäß § 34c Gewerbeordnung erteilt durch:<br>
                    Landeshauptstadt Stuttgart, Ordnungsamt
                </p>

                <h3>Zuständige Schlichtungsstelle</h3>
                <p>
                    Ombudsmann Immobilien IVD/VPB<br>
                    Graurheindorfer Straße 137a<br>
                    53117 Bonn
                </p>

                <h3>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h3>
                <p>
                    Max Mustermann<br>
                    Musterstraße 123<br>
                    70173 Stuttgart
                </p>

                <h3>Streitschlichtung</h3>
                <p>
                    Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit:
                    <a href="https://ec.europa.eu/consumers/odr/" target="_blank"
                        rel="noopener">https://ec.europa.eu/consumers/odr/</a>
                </p>
                <p>
                    Wir sind nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer
                    Verbraucherschlichtungsstelle teilzunehmen.
                </p>

                <h3>Haftung für Inhalte</h3>
                <p>
                    Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten
                    nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als
                    Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde
                    Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige
                    Tätigkeit hinweisen.
                </p>

                <h3>Haftung für Links</h3>
                <p>
                    Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen
                    Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen.
                    Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber
                    der Seiten verantwortlich.
                </p>

                <h3>Urheberrecht</h3>
                <p>
                    Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen
                    dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art
                    der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen
                    Zustimmung des jeweiligen Autors bzw. Erstellers.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .legal-content h2 {
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        color: var(--text);
    }

    .legal-content h3 {
        font-size: 1.25rem;
        margin-top: 2rem;
        margin-bottom: 0.75rem;
        color: var(--primary);
    }

    .legal-content p {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 1rem;
    }

    .legal-content a {
        color: var(--primary);
    }
</style>

<?= $this->endSection() ?>