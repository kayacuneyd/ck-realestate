<?php

namespace App\Modules\Agent\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Modules\Agent\Models\AgentModel;

/**
 * Frontend AgentController
 */
class AgentController extends BaseController
{
    protected AgentModel $model;

    public function __construct()
    {
        $this->model = new AgentModel();
        // helper(['agent']); // Helper will be created later
    }

    /**
     * Agent list page.
     */
    public function index(): string
    {
        $data = [
            'title' => 'Our Agents', // This will be moved to a language file
            'agents' => $this->model->findAll(), // We'll refine this later
        ];

        return view('App\Modules\Agent\Views\frontend\index', $data);
    }
}
