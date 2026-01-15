<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SponsorModel;

class SponsorController extends BaseController
{
    protected SponsorModel $sponsorModel;

    public function __construct()
    {
        $this->sponsorModel = new SponsorModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Sponsorlar / İş Ortakları',
            'sponsors' => $this->sponsorModel->orderBy('sort_order', 'ASC')->findAll(),
        ];

        return view('admin/properties/sponsors/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Yeni Sponsor Ekle',
        ];

        return view('admin/properties/sponsors/form', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'logo_url' => 'required',
            'website_url' => 'permit_empty|valid_url',
            'sort_order' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->sponsorModel->save([
            'name' => $this->request->getPost('name'),
            'logo_url' => $this->request->getPost('logo_url'),
            'website_url' => $this->request->getPost('website_url'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
        ]);

        return redirect()->to('/admin/sponsors')->with('message', 'Sponsor başarıyla eklendi.');
    }

    public function edit($id)
    {
        $sponsor = $this->sponsorModel->find($id);

        if (!$sponsor) {
            return redirect()->to('/admin/sponsors')->with('error', 'Sponsor bulunamadı.');
        }

        $data = [
            'title' => 'Sponsor Düzenle',
            'sponsor' => $sponsor,
        ];

        return view('admin/properties/sponsors/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'logo_url' => 'required',
            'website_url' => 'permit_empty|valid_url',
            'sort_order' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->sponsorModel->update($id, [
            'name' => $this->request->getPost('name'),
            'logo_url' => $this->request->getPost('logo_url'),
            'website_url' => $this->request->getPost('website_url'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
        ]);

        return redirect()->to('/admin/sponsors')->with('message', 'Sponsor başarıyla güncellendi.');
    }

    public function delete($id)
    {
        $this->sponsorModel->delete($id);
        return redirect()->to('/admin/sponsors')->with('message', 'Sponsor silindi.');
    }
}
