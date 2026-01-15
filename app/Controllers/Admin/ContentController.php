<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContentBlockModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Admin Content Controller
 * 
 * Manages editable content blocks for all pages.
 */
class ContentController extends BaseController
{
    protected ContentBlockModel $contentModel;

    /**
     * Page definitions with their editable content blocks.
     */
    protected array $pageDefinitions = [
        'home' => [
            'label' => 'Anasayfa (Home)',
            'blocks' => [
                'hero_title' => ['label' => 'Hero Başlık', 'type' => 'text'],
                'hero_subtitle' => ['label' => 'Hero Alt Başlık', 'type' => 'text'],
                'hero_badge' => ['label' => 'Hero Badge', 'type' => 'text'],
                'hero_button_listings' => ['label' => 'Hero Buton (İlanlar)', 'type' => 'text'],
                'hero_button_valuation' => ['label' => 'Hero Buton (Değerleme)', 'type' => 'text'],

                'trust_years_value' => ['label' => 'Güven: Yıl Değeri', 'type' => 'text'],
                'trust_years_label' => ['label' => 'Güven: Yıl Etiketi', 'type' => 'text'],
                'trust_closings_value' => ['label' => 'Güven: Satış Değeri', 'type' => 'text'],
                'trust_closings_label' => ['label' => 'Güven: Satış Etiketi', 'type' => 'text'],
                'trust_rating_value' => ['label' => 'Güven: Puan Değeri', 'type' => 'text'],
                'trust_rating_label' => ['label' => 'Güven: Puan Etiketi', 'type' => 'text'],

                'services_title' => ['label' => 'Hizmetler Başlık', 'type' => 'text'],
                'services_subtitle' => ['label' => 'Hizmetler Alt Başlık', 'type' => 'text'],

                'cta_title' => ['label' => 'CTA Başlık', 'type' => 'text'],
                'cta_subtitle' => ['label' => 'CTA Alt Başlık', 'type' => 'text'],
                'cta_button' => ['label' => 'CTA Buton', 'type' => 'text'],
            ],
        ],
        'about' => [
            'label' => 'Hakkımızda (About)',
            'blocks' => [
                'page_title' => ['label' => 'Sayfa Başlığı', 'type' => 'text'],
                'page_subtitle' => ['label' => 'Sayfa Alt Başlığı', 'type' => 'text'],
                'mission_title' => ['label' => 'Misyon Başlık', 'type' => 'text'],
                'mission_text' => ['label' => 'Misyon Metni', 'type' => 'textarea'],
                'vision_title' => ['label' => 'Vizyon Başlık', 'type' => 'text'],
                'vision_text' => ['label' => 'Vizyon Metni', 'type' => 'textarea'],
            ],
        ],
        'how-it-works' => [
            'label' => 'Wie es funktioniert',
            'blocks' => [
                'page_title' => ['label' => 'Sayfa Başlığı', 'type' => 'text'],
                'page_subtitle' => ['label' => 'Sayfa Alt Başlığı', 'type' => 'text'],
                'section_title' => ['label' => 'Bölüm Başlığı', 'type' => 'text'],
                'section_subtitle' => ['label' => 'Bölüm Alt Başlığı', 'type' => 'text'],
                'step1_title' => ['label' => 'Adım 1 Başlık', 'type' => 'text'],
                'step1_text' => ['label' => 'Adım 1 Metin', 'type' => 'textarea'],
                'step2_title' => ['label' => 'Adım 2 Başlık', 'type' => 'text'],
                'step2_text' => ['label' => 'Adım 2 Metin', 'type' => 'textarea'],
                'step3_title' => ['label' => 'Adım 3 Başlık', 'type' => 'text'],
                'step3_text' => ['label' => 'Adım 3 Metin', 'type' => 'textarea'],
                'step4_title' => ['label' => 'Adım 4 Başlık', 'type' => 'text'],
                'step4_text' => ['label' => 'Adım 4 Metin', 'type' => 'textarea'],
                'step5_title' => ['label' => 'Adım 5 Başlık', 'type' => 'text'],
                'step5_text' => ['label' => 'Adım 5 Metin', 'type' => 'textarea'],
                'cta_title' => ['label' => 'CTA Başlık', 'type' => 'text'],
                'cta_text' => ['label' => 'CTA Metin', 'type' => 'text'],
                'cta_button' => ['label' => 'CTA Buton', 'type' => 'text'],
            ],
        ],
        'references' => [
            'label' => 'Referenzen',
            'blocks' => [
                'page_title' => ['label' => 'Sayfa Başlığı', 'type' => 'text'],
                'page_subtitle' => ['label' => 'Sayfa Alt Başlığı', 'type' => 'text'],
                'stat1_value' => ['label' => 'İstatistik 1 Değer', 'type' => 'text'],
                'stat1_label' => ['label' => 'İstatistik 1 Etiket', 'type' => 'text'],
                'stat2_value' => ['label' => 'İstatistik 2 Değer', 'type' => 'text'],
                'stat2_label' => ['label' => 'İstatistik 2 Etiket', 'type' => 'text'],
                'stat3_value' => ['label' => 'İstatistik 3 Değer', 'type' => 'text'],
                'stat3_label' => ['label' => 'İstatistik 3 Etiket', 'type' => 'text'],
                'stat4_value' => ['label' => 'İstatistik 4 Değer', 'type' => 'text'],
                'stat4_label' => ['label' => 'İstatistik 4 Etiket', 'type' => 'text'],
                'testimonials_title' => ['label' => 'Müşteri Yorumları Başlık', 'type' => 'text'],
                'testimonials_subtitle' => ['label' => 'Müşteri Yorumları Alt Başlık', 'type' => 'text'],

                // Testimonial 1
                'testimonial1_text' => ['label' => 'Yorum 1 Metin', 'type' => 'textarea'],
                'testimonial1_author' => ['label' => 'Yorum 1 Yazar', 'type' => 'text'],
                'testimonial1_detail' => ['label' => 'Yorum 1 Detay', 'type' => 'text'],

                // Testimonial 2
                'testimonial2_text' => ['label' => 'Yorum 2 Metin', 'type' => 'textarea'],
                'testimonial2_author' => ['label' => 'Yorum 2 Yazar', 'type' => 'text'],
                'testimonial2_detail' => ['label' => 'Yorum 2 Detay', 'type' => 'text'],

                // Testimonial 3
                'testimonial3_text' => ['label' => 'Yorum 3 Metin', 'type' => 'textarea'],
                'testimonial3_author' => ['label' => 'Yorum 3 Yazar', 'type' => 'text'],
                'testimonial3_detail' => ['label' => 'Yorum 3 Detay', 'type' => 'text'],
            ],
        ],
        'contact' => [
            'label' => 'İletişim (Contact)',
            'blocks' => [
                'page_title' => ['label' => 'Sayfa Başlığı', 'type' => 'text'],
                'page_subtitle' => ['label' => 'Sayfa Alt Başlığı', 'type' => 'text'],
                'form_title' => ['label' => 'Form Başlığı', 'type' => 'text'],
                'form_subtitle' => ['label' => 'Form Alt Başlığı', 'type' => 'text'],
                'address' => ['label' => 'Adres', 'type' => 'textarea'],
                'phone' => ['label' => 'Telefon', 'type' => 'text'],
                'email' => ['label' => 'E-posta', 'type' => 'text'],
                'hours' => ['label' => 'Çalışma Saatleri', 'type' => 'text'],
            ],
        ],
        'footer' => [
            'label' => 'Footer',
            'blocks' => [
                'brand_description' => ['label' => 'Marka Açıklaması', 'type' => 'textarea'],
                'address' => ['label' => 'Adres', 'type' => 'text'],
                'phone' => ['label' => 'Telefon', 'type' => 'text'],
                'email' => ['label' => 'E-posta', 'type' => 'text'],
                'hours' => ['label' => 'Çalışma Saatleri', 'type' => 'text'],
                'stat1' => ['label' => 'İstatistik 1', 'type' => 'text'],
                'stat2' => ['label' => 'İstatistik 2', 'type' => 'text'],
                'stat3' => ['label' => 'İstatistik 3', 'type' => 'text'],
            ],
        ],
        'settings' => [
            'label' => 'Genel Ayarlar (Global Settings)',
            'blocks' => [
                'company_name' => ['label' => 'Şirket Adı', 'type' => 'text'],
                'company_address' => ['label' => 'Adres (Tüm Site)', 'type' => 'text'],
                'company_phone' => ['label' => 'Telefon (Tüm Site)', 'type' => 'text'],
                'company_email' => ['label' => 'E-posta (Tüm Site)', 'type' => 'text'],
                'company_hours' => ['label' => 'Çalışma Saatleri (Tüm Site)', 'type' => 'text'],

                'social_facebook' => ['label' => 'Facebook URL', 'type' => 'text'],
                'social_instagram' => ['label' => 'Instagram URL', 'type' => 'text'],
                'social_linkedin' => ['label' => 'LinkedIn URL', 'type' => 'text'],
            ],
        ],
    ];

    public function __construct()
    {
        $this->contentModel = new ContentBlockModel();
    }

    /**
     * Show content management dashboard.
     */
    public function index(): string
    {
        $data = [
            'title' => 'Content Management',
            'pages' => $this->pageDefinitions,
        ];

        return view('admin/content/index', $data);
    }

    /**
     * Edit content for a specific page.
     */
    public function edit(string $page): string
    {
        if (!isset($this->pageDefinitions[$page])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $pageConfig = $this->pageDefinitions[$page];
        $currentContent = $this->contentModel->getPageContent($page);

        $data = [
            'title' => 'İçerik Düzenle: ' . $pageConfig['label'],
            'page' => $page,
            'pageLabel' => $pageConfig['label'],
            'blocks' => $pageConfig['blocks'],
            'content' => $currentContent,
        ];

        return view('admin/content/edit', $data);
    }

    /**
     * Save content for a page.
     */
    public function save(string $page): RedirectResponse
    {
        if (!isset($this->pageDefinitions[$page])) {
            return redirect()->to('/admin/content');
        }

        $blocks = $this->pageDefinitions[$page]['blocks'];

        foreach ($blocks as $key => $config) {
            $value = $this->request->getPost($key) ?? '';
            $this->contentModel->setContent($page, $key, $value, $config['type']);
        }

        return redirect()->to('/admin/content/' . $page)
            ->with('message', 'İçerik başarıyla kaydedildi.');
    }
}
