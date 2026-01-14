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
}
