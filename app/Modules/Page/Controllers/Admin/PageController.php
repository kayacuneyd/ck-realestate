<?php

namespace App\Modules\Page\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\Page\Models\PageModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class PageController extends BaseController
{
    protected PageModel $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
        helper(['form', 'ck']);
    }

    public function index(): string
    {
        $query = trim((string) $this->request->getGet('q'));
        $status = (string) $this->request->getGet('status');

        $builder = $this->pageModel->builder()->orderBy('created_at', 'DESC');
        if ($query !== '') {
            $builder->groupStart()
                ->like('title', $query)
                ->orLike('slug', $query)
                ->groupEnd();
        }
        if ($status !== '') {
            $builder->where('is_active', $status === 'active' ? 1 : 0);
        }

        $data = [
            'title' => 'Pages',
            'pages' => $builder->get()->getResult($this->pageModel->returnType),
            'filters' => [
                'q' => $query,
                'status' => $status,
            ],
        ];

        return view('App\Modules\Page\Views\admin\index', $data);
    }

    public function create(): string
    {
        return view('App\Modules\Page\Views\admin\create', [
            'title' => 'Create Page',
            'page' => null,
        ]);
    }

    public function store(): RedirectResponse
    {
        $data = $this->request->getPost();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? '', $data['title'] ?? '');
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (!$this->pageModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->pageModel->errors());
        }

        return redirect()->to('/admin/pages')->with('message', 'Page created successfully.');
    }

    public function show(int $id): string|RedirectResponse
    {
        $page = $this->pageModel->find($id);
        if ($page === null) {
            return redirect()->to('/admin/pages')->with('error', 'Page not found.');
        }

        return view('App\Modules\Page\Views\admin\show', [
            'title' => $page->title,
            'page' => $page,
        ]);
    }

    public function edit(int $id): string|RedirectResponse
    {
        $page = $this->pageModel->find($id);
        if ($page === null) {
            return redirect()->to('/admin/pages')->with('error', 'Page not found.');
        }

        return view('App\Modules\Page\Views\admin\edit', [
            'title' => 'Edit Page',
            'page' => $page,
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $page = $this->pageModel->find($id);
        if ($page === null) {
            return redirect()->to('/admin/pages')->with('error', 'Page not found.');
        }

        $data = $this->request->getPost();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? '', $data['title'] ?? '', $id);
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (!$this->pageModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->pageModel->errors());
        }

        return redirect()->to('/admin/pages')->with('message', 'Page updated successfully.');
    }

    public function delete(int $id): RedirectResponse
    {
        $page = $this->pageModel->find($id);
        if ($page === null) {
            return redirect()->to('/admin/pages')->with('error', 'Page not found.');
        }

        $this->pageModel->delete($id);
        return redirect()->to('/admin/pages')->with('message', 'Page deleted successfully.');
    }

    public function upload(): ResponseInterface
    {
        $file = $this->request->getFile('image');

        if ($file === null || !$file->isValid()) {
            return $this->response->setJSON(['error' => 'Invalid upload.'])->setStatusCode(400);
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower($file->getExtension());
        if (!in_array($ext, $allowed, true)) {
            return $this->response->setJSON(['error' => 'Unsupported file type.'])->setStatusCode(400);
        }

        $path = $this->uploadToStorage($file);
        if ($path === null) {
            return $this->response->setJSON(['error' => 'Upload failed.'])->setStatusCode(500);
        }

        return $this->response->setJSON(['url' => $path]);
    }

    private function uniqueSlug(string $slug, string $title, ?int $excludeId = null): string
    {
        $base = $slug !== '' ? $slug : generate_slug($title !== '' ? $title : 'page');
        $candidate = $base;
        $counter = 1;

        while (true) {
            $builder = $this->pageModel->builder()->where('slug', $candidate);
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

    private function uploadToStorage($file): ?string
    {
        $bucket = env('R2_BUCKET');
        $endpoint = env('R2_ENDPOINT');
        $key = env('R2_ACCESS_KEY_ID');
        $secret = env('R2_SECRET_ACCESS_KEY');
        $publicUrl = rtrim((string) env('R2_PUBLIC_URL'), '/');

        if ($bucket && $endpoint && $key && $secret && class_exists('Aws\\S3\\S3Client')) {
            $client = new \Aws\S3\S3Client([
                'version' => 'latest',
                'region' => 'auto',
                'endpoint' => $endpoint,
                'credentials' => [
                    'key' => $key,
                    'secret' => $secret,
                ],
            ]);

            $name = 'pages/' . $file->getRandomName();
            $result = $client->putObject([
                'Bucket' => $bucket,
                'Key' => $name,
                'Body' => fopen($file->getTempName(), 'rb'),
                'ContentType' => $file->getMimeType(),
            ]);

            if ($publicUrl !== '') {
                return $publicUrl . '/' . $name;
            }

            return $result['ObjectURL'] ?? null;
        }

        $uploadDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'pages';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = $file->getRandomName();
        $file->move($uploadDir, $fileName);

        return base_url('uploads/pages/' . $fileName);
    }
}
