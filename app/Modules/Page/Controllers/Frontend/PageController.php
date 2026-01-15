<?php

namespace App\Modules\Page\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Modules\Page\Models\PageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Frontend PageController
 */
class PageController extends BaseController
{
    protected PageModel $model;

    public function __construct()
    {
        $this->model = new PageModel();
    }

    /**
     * Display a static page.
     * @param string $slug
     * @return string
     */
    public function show(string $slug): string
    {
        $page = $this->model->where('slug', $slug)->where('is_active', 1)->first();

        if ($page === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $page->title,
            'page' => $page,
        ];

        return view('App\Modules\Page\Views\frontend\show', $data);
    }

    /**
     * Display the About Us page.
     * @return string
     */
    public function about(): string
    {
        $data = [
            'title' => 'About Us',
        ];

        return view('App\Modules\Page\Views\frontend\about', $data);
    }

    /**
     * Display the Contact Us page.
     * @return string
     */
    public function contact(): string
    {
        $data = [
            'title' => 'Contact Us',
        ];

        return view('App\Modules\Page\Views\frontend\contact', $data);
    }

    /**
     * Display the How It Works page.
     * @return string
     */
    public function howItWorks(): string
    {
        $data = [
            'title' => 'Wie es funktioniert',
        ];

        return view('App\Modules\Page\Views\frontend\how-it-works', $data);
    }

    /**
     * Display the References page.
     * @return string
     */
    public function references(): string
    {
        $sponsorModel = new \App\Models\SponsorModel();
        $sponsors = $sponsorModel->orderBy('sort_order', 'ASC')->findAll();

        $data = [
            'title' => 'Referenzen',
            'sponsors' => $sponsors,
        ];

        return view('App\Modules\Page\Views\frontend\references', $data);
    }

    /**
     * Display the Imprint page.
     * @return string
     */
    public function imprint(): string
    {
        $data = [
            'title' => 'Impressum',
        ];

        return view('App\Modules\Page\Views\frontend\imprint', $data);
    }

    /**
     * Display the Privacy Policy page.
     * @return string
     */
    public function datenschutz(): string
    {
        $data = [
            'title' => 'Datenschutzerklärung',
        ];

        return view('App\Modules\Page\Views\frontend\datenschutz', $data);
    }
}
