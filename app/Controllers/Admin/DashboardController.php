<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Modules\Page\Models\PageModel;
use App\Modules\Property\Models\PropertyModel;

/**
 * DashboardController
 *
 * Simple controller for the administrative dashboard.
 * Requires authentication via the auth filter.
 */
class DashboardController extends BaseController
{
    /**
     * Display the admin dashboard.
     *
     * @return string
     */
    public function index(): string
    {
        $propertyModel = new PropertyModel();
        $pageModel = new PageModel();
        $userModel = new UserModel();

        $data = [
            'title' => 'Admin Dashboard',
            'kpis' => [
                [
                    'label' => 'Properties',
                    'value' => $propertyModel->countAllResults(),
                    'trend' => 'Active listings in the system',
                ],
                [
                    'label' => 'Pages',
                    'value' => $pageModel->countAllResults(),
                    'trend' => 'Published content pages',
                ],
                [
                    'label' => 'Users',
                    'value' => $userModel->countAllResults(),
                    'trend' => 'Admin accounts',
                ],
            ],
            'recentProperties' => $propertyModel->orderBy('created_at', 'DESC')->findAll(5),
        ];

        return view('admin/dashboard', $data);
    }
}

