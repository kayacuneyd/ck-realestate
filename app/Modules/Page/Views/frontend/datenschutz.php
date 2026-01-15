<?= $this->extend('App\Views\layouts\frontend') ?>

<?= $this->section('content') ?>

<?= view('App\Views\components\page_header', [
    'title' => 'Datenschutzerklärung',
    'subtitle' => 'Informationen zum Schutz Ihrer Daten',
    'breadcrumb' => [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Datenschutz']
    ]
]) ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="legal-content">
                <h2>1. Datenschutz auf einen Blick</h2>

                <h3>Allgemeine Hinweise</h3>
                <p>
                    Die folgenden Hinweise geben einen einfachen Überblick darüber, was mit Ihren
                    personenbezogenen Daten passiert, wenn Sie diese Website besuchen. Personenbezogene
                    Daten sind alle Daten, mit denen Sie persönlich identifiziert werden können.
                </p>

                <h3>Datenerfassung auf dieser Website</h3>
                <p>
                    <strong>Wer ist verantwortlich für die Datenerfassung auf dieser Website?</strong><br>
                    Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber.
                    Dessen Kontaktdaten können Sie dem Impressum dieser Website entnehmen.
                </p>

                <p>
                    <strong>Wie erfassen wir Ihre Daten?</strong><br>
                    Ihre Daten werden zum einen dadurch erhoben, dass Sie uns diese mitteilen.
                    Hierbei kann es sich z.B. um Daten handeln, die Sie in ein Kontaktformular eingeben.
                </p>

                <h2>2. Hosting</h2>
                <p>
                    Wir hosten die Inhalte unserer Website bei folgendem Anbieter:
                </p>
                <p>
                    <strong>Externes Hosting</strong><br>
                    Diese Website wird extern gehostet. Die personenbezogenen Daten, die auf dieser
                    Website erfasst werden, werden auf den Servern des Hosters gespeichert.
                </p>

                <h2>3. Allgemeine Hinweise und Pflichtinformationen</h2>

                <h3>Datenschutz</h3>
                <p>
                    Die Betreiber dieser Seiten nehmen den Schutz Ihrer persönlichen Daten sehr ernst.
                    Wir behandeln Ihre personenbezogenen Daten vertraulich und entsprechend den
                    gesetzlichen Datenschutzvorschriften sowie dieser Datenschutzerklärung.
                </p>

                <h3>Hinweis zur verantwortlichen Stelle</h3>
                <p>
                    Die verantwortliche Stelle für die Datenverarbeitung auf dieser Website ist:
                </p>
                <p>
                    Bawue Immobilien GmbH<br>
                    Musterstraße 123<br>
                    70173 Stuttgart<br>
                    Telefon: +49 (0) 711 123 456 78<br>
                    E-Mail: datenschutz@bawue-immobilien.de
                </p>

                <h3>Speicherdauer</h3>
                <p>
                    Soweit innerhalb dieser Datenschutzerklärung keine speziellere Speicherdauer genannt
                    wurde, verbleiben Ihre personenbezogenen Daten bei uns, bis der Zweck für die
                    Datenverarbeitung entfällt.
                </p>

                <h2>4. Datenerfassung auf dieser Website</h2>

                <h3>Cookies</h3>
                <p>
                    Unsere Internetseiten verwenden so genannte „Cookies". Cookies sind kleine
                    Datenpakete und richten auf Ihrem Endgerät keinen Schaden an. Sie werden entweder
                    vorübergehend für die Dauer einer Sitzung (Session-Cookies) oder dauerhaft
                    (permanente Cookies) auf Ihrem Endgerät gespeichert.
                </p>

                <h3>Kontaktformular</h3>
                <p>
                    Wenn Sie uns per Kontaktformular Anfragen zukommen lassen, werden Ihre Angaben
                    aus dem Anfrageformular inklusive der von Ihnen dort angegebenen Kontaktdaten
                    zwecks Bearbeitung der Anfrage und für den Fall von Anschlussfragen bei uns
                    gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.
                </p>

                <h3>Anfrage per E-Mail, Telefon oder Telefax</h3>
                <p>
                    Wenn Sie uns per E-Mail, Telefon oder Telefax kontaktieren, wird Ihre Anfrage
                    inklusive aller daraus hervorgehenden personenbezogenen Daten (Name, Anfrage)
                    zum Zwecke der Bearbeitung Ihres Anliegens bei uns gespeichert und verarbeitet.
                </p>

                <h2>5. Ihre Rechte</h2>
                <p>Sie haben folgende Rechte:</p>
                <ul>
                    <li><strong>Auskunftsrecht:</strong> Sie können Auskunft über Ihre von uns verarbeiteten
                        personenbezogenen Daten verlangen.</li>
                    <li><strong>Berichtigungsrecht:</strong> Sie können die Berichtigung unrichtiger oder
                        Vervollständigung Ihrer bei uns gespeicherten personenbezogenen Daten verlangen.</li>
                    <li><strong>Löschungsrecht:</strong> Sie können die Löschung Ihrer bei uns gespeicherten
                        personenbezogenen Daten verlangen.</li>
                    <li><strong>Einschränkungsrecht:</strong> Sie können die Einschränkung der Verarbeitung Ihrer
                        personenbezogenen Daten verlangen.</li>
                    <li><strong>Widerspruchsrecht:</strong> Sie können der Verarbeitung Ihrer personenbezogenen Daten
                        widersprechen.</li>
                    <li><strong>Recht auf Datenübertragbarkeit:</strong> Sie können verlangen, dass wir Ihnen Ihre
                        personenbezogenen Daten in einem strukturierten, gängigen und maschinenlesbaren Format
                        übermitteln.</li>
                </ul>

                <h2>6. SSL- bzw. TLS-Verschlüsselung</h2>
                <p>
                    Diese Seite nutzt aus Sicherheitsgründen und zum Schutz der Übertragung
                    vertraulicher Inhalte eine SSL- bzw. TLS-Verschlüsselung. Eine verschlüsselte
                    Verbindung erkennen Sie daran, dass die Adresszeile des Browsers von „http://"
                    auf „https://" wechselt und an dem Schloss-Symbol in Ihrer Browserzeile.
                </p>

                <p class="text-muted mt-5">
                    <small>Stand: Januar 2026</small>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .legal-content h2 {
        font-size: 1.75rem;
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
        color: var(--text);
    }

    .legal-content h2:first-child {
        margin-top: 0;
    }

    .legal-content h3 {
        font-size: 1.25rem;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        color: var(--primary);
    }

    .legal-content p {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 1rem;
    }

    .legal-content ul {
        color: var(--text-muted);
        line-height: 1.8;
    }

    .legal-content li {
        margin-bottom: 0.5rem;
    }

    .legal-content a {
        color: var(--primary);
    }
</style>

<?= $this->endSection() ?>