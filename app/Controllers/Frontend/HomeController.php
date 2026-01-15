<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

/**
 * HomeController
 *
 * Handles the site homepage.  For now this simply returns
 * a placeholder view.  Additional logic can be added later.
 */
class HomeController extends BaseController
{
    /**
     * Show the site home page.
     *
     * @return string
     */
    public function index(): string
    {
        $this->helpers[] = 'language';
        lang('Home');

        // Fetch featured properties
        $propertyModel = new \App\Modules\Property\Models\PropertyModel();
        $featuredProperties = $propertyModel->getFeatured(3);

        $data = [
            'title' => lang('Home.title'),
            'featuredProperties' => $featuredProperties,
        ];
        return view('frontend/home', $data);
    }
}
