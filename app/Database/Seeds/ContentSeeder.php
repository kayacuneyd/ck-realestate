<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\ContentBlockModel;

/**
 * Seeds initial content from existing page templates with professional copy.
 */
class ContentSeeder extends Seeder
{
    public function run()
    {
        $model = new ContentBlockModel();

        // TRUNCATE table first to ensure we start fresh with the new structure
        $this->db->table('content_blocks')->truncate();

        // Home page
        $model->initDefaults('home', [
            'hero_title' => 'Finden Sie Ihr Traumhaus in Baden-Württemberg',
            'hero_subtitle' => 'Exklusive Immobilien, maßgeschneiderte Beratung und lokale Expertise – Ihr Partner für erstklassiges Wohnen.',
            'hero_badge' => 'Aktuelle Angebote • Provisionsfrei',
            'hero_button_listings' => 'Objekte entdecken',
            'hero_button_valuation' => 'Wert ermitteln',

            'trust_years_value' => '15+',
            'trust_years_label' => 'Jahre Erfahrung',
            'trust_closings_value' => '500+',
            'trust_closings_label' => 'Erfolgreiche Verkäufe',
            'trust_rating_value' => '4.9/5',
            'trust_rating_label' => 'Kundenbewertung',

            'services_title' => 'Unser Leistungsspektrum',
            'services_subtitle' => 'Ganzheitliche Immobilienlösungen für Verkäufer, Käufer und Investoren.',

            'cta_title' => 'Bereit für den nächsten Schritt?',
            'cta_subtitle' => 'Lassen Sie uns gemeinsam Ihre Immobilienziele verwirklichen.',
            'cta_button' => 'Kostenloses Erstgespräch vereinbaren',
        ]);

        // How it works page
        $model->initDefaults('how-it-works', [
            'page_title' => 'Wie es funktioniert',
            'page_subtitle' => 'Ihr transparenter Weg zum erfolgreichen Immobilienverkauf',
            'section_title' => 'In 5 Schritten zum Verkaufserfolg',
            'section_subtitle' => 'Ein strukturierter Prozess für maximale Transparenz und Sicherheit.',

            'step1_title' => 'Kostenlose Erstberatung',
            'step1_text' => 'In einem unverbindlichen Gespräch analysieren wir Ihre Situation und Ziele. Wir klären erste Fragen und skizzieren die möglichen Verkaufsstrategien.',

            'step2_title' => 'Fundierte Wertermittlung',
            'step2_text' => 'Unsere Experten bewerten Ihre Immobilie basierend auf aktuellen Marktdaten, Lagefaktoren und Objektzustand, um den optimalen Angebotspreis zu definieren.',

            'step3_title' => 'Premium-Vermarktung',
            'step3_text' => 'Wir setzen Ihre Immobilie perfekt in Szene – mit professionellen Fotos, 360°-Rundgängen und einem exklusiven Exposé. Die Vermarktung erfolgt über alle relevanten Kanäle.',

            'step4_title' => 'Besichtigungsmanagement',
            'step4_text' => 'Wir prüfen Interessenten vorab (Bonitätscheck) und führen nur qualifizierte Besichtigungen durch. Sie sparen Zeit und Nerven.',

            'step5_title' => 'Erfolgreicher Abschluss',
            'step5_text' => 'Wir führen die Preisverhandlungen, bereiten den Notartermin vor und begleiten Sie bis zur finalen Schlüsselübergabe.',

            'cta_title' => 'Starten Sie jetzt Ihren Verkauf',
            'cta_text' => 'Profitieren Sie von unserer Erfahrung und Marktkenntnis.',
            'cta_button' => 'Jetzt Beratung anfordern',
        ]);

        // References page
        $model->initDefaults('references', [
            'page_title' => 'Referenzen & Erfolge',
            'page_subtitle' => 'Das Vertrauen unserer Kunden ist unsere größte Auszeichnung.',

            'stat1_value' => '500+',
            'stat1_label' => 'Vermittelte Objekte',
            'stat2_value' => '15+',
            'stat2_label' => 'Jahre am Markt',
            'stat3_value' => '4.9',
            'stat3_label' => 'Sterne Bewertung',
            'stat4_value' => '98%',
            'stat4_label' => 'Weiterempfehlungsrate',

            'testimonials_title' => 'Kundenstimmen',
            'testimonials_subtitle' => 'Erfahren Sie, was Eigentümer und Käufer über die Zusammenarbeit mit uns berichten.',

            // Testimonials
            'testimonial1_text' => 'Vom ersten Gespräch bis zum Notartermin fühlten wir uns bestens aufgehoben. Die Bewertung war realistisch und der Verkauf ging schneller als gedacht. Absolut professionell!',
            'testimonial1_author' => 'Michael K.',
            'testimonial1_detail' => 'Verkauf Einfamilienhaus, Stuttgart',

            'testimonial2_text' => 'Besonders beeindruckt hat uns das hochwertige Exposé und die virtuelle Besichtigung. Das Team war jederzeit erreichbar und hat uns kompetent beraten.',
            'testimonial2_author' => 'Sabine F.',
            'testimonial2_detail' => 'Kauf Eigentumswohnung, Tübingen',

            'testimonial3_text' => 'Als Erbengemeinschaft war uns eine neutrale und transparente Abwicklung wichtig. Bawue Immobilien hat das hervorragend gemeistert. Klare Empfehlung!',
            'testimonial3_author' => 'Thomas W.',
            'testimonial3_detail' => 'Verkauf Mehrfamilienhaus, Esslingen',
        ]);

        // About page
        $model->initDefaults('about', [
            'page_title' => 'Über Uns',
            'page_subtitle' => 'Kompetenz, Leidenschaft und lokale Verwurzelung.',

            'mission_title' => 'Unsere Mission',
            'mission_text' => 'Wir verstehen Immobilien nicht nur als Objekte, sondern als Lebensräume und Kapitalanlagen. Unsere Mission ist es, für jeden Kunden das bestmögliche Ergebnis zu erzielen – sei es beim Verkauf, Kauf oder der Vermietung. Dabei setzen wir auf Ehrlichkeit, Transparenz und modernste Vermarktungsmethoden.',

            'vision_title' => 'Unsere Vision',
            'vision_text' => 'Als führender Immobilienpartner in Baden-Württemberg setzen wir neue Standards in der Kundenbetreuung. Wir verbinden traditionelle Werte mit innovativen Technologien, um den Immobilienmarkt für alle Beteiligten effizienter und transparenter zu gestalten.',
        ]);

        // Contact page
        $model->initDefaults('contact', [
            'page_title' => 'Kontaktieren Sie uns',
            'page_subtitle' => 'Wir sind für Sie da – persönlich, telefonisch oder digital.',
            'form_title' => 'Schreiben Sie uns eine Nachricht',
            'form_subtitle' => 'Haben Sie Fragen zu einem Objekt oder möchten Sie Ihre Immobilie bewerten lassen? Füllen Sie einfach das Formular aus.',
            'address' => 'Königstraße 26, 70173 Stuttgart',
            'phone' => '+49 711 987 654 32',
            'email' => 'kontakt@bawue-immobilien.de',
            'hours' => 'Mo - Fr: 09:00 - 18:00 Uhr',
        ]);

        // Footer
        $model->initDefaults('footer', [
            'brand_description' => 'Ihr Experte für Immobilien in Stuttgart und Umgebung. Wir begleiten Sie kompetent durch den gesamten Kauf- oder Verkaufsprozess.',
            'address' => 'Königstraße 26, 70173 Stuttgart',
            'phone' => '+49 711 987 654 32',
            'email' => 'kontakt@bawue-immobilien.de',
            'hours' => 'Mo - Fr: 09:00 - 18:00 Uhr',
            'stat1' => '15+ Jahre Marktpräsenz',
            'stat2' => '500+ Objekte vermittelt',
            'stat3' => 'Exzellente Kundenbewertungen',
        ]);

        // Global Settings
        $model->initDefaults('settings', [
            'company_name' => 'Bawue Immobilien',
            'company_address' => 'Königstraße 26, 70173 Stuttgart',
            'company_phone' => '+49 711 987 654 32',
            'company_email' => 'kontakt@bawue-immobilien.de',
            'company_hours' => 'Mo - Fr: 09:00 - 18:00 Uhr',
            'social_facebook' => '#',
            'social_instagram' => '#',
            'social_linkedin' => '#',
        ]);

        echo "Content blocks initialized successfully with professional copy.\n";
    }
}
