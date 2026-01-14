<?php

namespace App\Modules\Agent\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\Agent\Models\AgentModel;
use CodeIgniter\HTTP\RedirectResponse;

class AgentController extends BaseController
{
    protected AgentModel $agentModel;

    public function __construct()
    {
        $this->agentModel = new AgentModel();
        helper(['form', 'ck']);
    }

    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $status = (string) $this->request->getGet('status');

        $builder = $this->agentModel->builder()->orderBy('created_at', 'DESC');
        if ($query !== '') {
            $builder->groupStart()
                ->like('name', $query)
                ->orLike('email', $query)
                ->orLike('title', $query)
                ->groupEnd();
        }
        if ($status !== '') {
            $builder->where('is_active', $status === 'active' ? 1 : 0);
        }

        $data = [
            'title' => 'Agents',
            'agents' => $builder->get()->getResult($this->agentModel->returnType),
            'filters' => [
                'q' => $query,
                'status' => $status,
            ],
        ];

        return view('App\Modules\Agent\Views\admin\index', $data);
    }

    public function create(): string
    {
        return view('App\Modules\Agent\Views\admin\create', [
            'title' => 'Create Agent',
            'agent' => null,
        ]);
    }

    public function store(): RedirectResponse
    {
        $data = $this->request->getPost();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? '', $data['name'] ?? '');
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (!$this->agentModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->agentModel->errors());
        }

        return redirect()->to('/admin/agents')->with('message', 'Agent created successfully.');
    }

    public function show(int $id): string|RedirectResponse
    {
        $agent = $this->agentModel->find($id);
        if ($agent === null) {
            return redirect()->to('/admin/agents')->with('error', 'Agent not found.');
        }

        return view('App\Modules\Agent\Views\admin\show', [
            'title' => $agent->name,
            'agent' => $agent,
        ]);
    }

    public function edit(int $id): string|RedirectResponse
    {
        $agent = $this->agentModel->find($id);
        if ($agent === null) {
            return redirect()->to('/admin/agents')->with('error', 'Agent not found.');
        }

        return view('App\Modules\Agent\Views\admin\edit', [
            'title' => 'Edit Agent',
            'agent' => $agent,
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $agent = $this->agentModel->find($id);
        if ($agent === null) {
            return redirect()->to('/admin/agents')->with('error', 'Agent not found.');
        }

        $data = $this->request->getPost();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? '', $data['name'] ?? '', $id);
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (!$this->agentModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->agentModel->errors());
        }

        return redirect()->to('/admin/agents')->with('message', 'Agent updated successfully.');
    }

    public function delete(int $id): RedirectResponse
    {
        $agent = $this->agentModel->find($id);
        if ($agent === null) {
            return redirect()->to('/admin/agents')->with('error', 'Agent not found.');
        }

        $this->agentModel->delete($id);
        return redirect()->to('/admin/agents')->with('message', 'Agent deleted successfully.');
    }

    private function uniqueSlug(string $slug, string $name, ?int $excludeId = null): string
    {
        $base = $slug !== '' ? $slug : generate_slug($name !== '' ? $name : 'agent');
        $candidate = $base;
        $counter = 1;

        while (true) {
            $builder = $this->agentModel->builder()->where('slug', $candidate);
            if ($excludeId !== null) {
                $builder->where('id !=', $excludeId);
            }
            if ($builder->countAllResults() === 0) {
                break;
            }
            $candidate = $base . '-' . $counter;
            $counter++;
        }

        return $candidate;
    }
}
