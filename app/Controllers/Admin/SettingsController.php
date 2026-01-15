<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Admin Settings Controller
 * 
 * Manages site-wide settings including logo and hero background image.
 */
class SettingsController extends BaseController
{
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    /**
     * Display settings form.
     */
    public function index(): string
    {
        $data = [
            'title' => 'Site Settings',
            'settings' => [
                'site_logo' => $this->settingModel->getValue('site_logo', ''),
                'hero_background_image' => $this->settingModel->getValue('hero_background_image', ''),
                'hero_overlay_opacity' => $this->settingModel->getValue('hero_overlay_opacity', '0.5'),
            ],
        ];

        return view('admin/settings', $data);
    }

    /**
     * Save settings.
     */
    public function save(): RedirectResponse
    {
        // Handle logo upload
        $logoFile = $this->request->getFile('site_logo');
        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            $validTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'];
            if (!in_array($logoFile->getMimeType(), $validTypes)) {
                return redirect()->back()->with('error', 'Invalid logo file type.');
            }

            if ($logoFile->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('error', 'Logo file too large. Maximum size is 2MB.');
            }

            $newName = 'logo_' . time() . '.' . $logoFile->getExtension();
            $uploadPath = FCPATH . 'uploads/images';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $logoFile->move($uploadPath, $newName);

            // Delete old logo if exists
            $oldLogo = $this->settingModel->getValue('site_logo');
            if ($oldLogo && file_exists(FCPATH . ltrim($oldLogo, '/'))) {
                unlink(FCPATH . ltrim($oldLogo, '/'));
            }

            $this->settingModel->setValue('site_logo', '/uploads/images/' . $newName);
        }

        // Handle logo removal
        if ($this->request->getPost('remove_logo') === '1') {
            $oldLogo = $this->settingModel->getValue('site_logo');
            if ($oldLogo && file_exists(FCPATH . ltrim($oldLogo, '/'))) {
                unlink(FCPATH . ltrim($oldLogo, '/'));
            }
            $this->settingModel->setValue('site_logo', '');
        }

        // Handle hero background image upload
        $file = $this->request->getFile('hero_background_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($file->getMimeType(), $validTypes)) {
                return redirect()->back()->with('error', 'Invalid file type. Please upload JPG, PNG, or WebP.');
            }

            if ($file->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->with('error', 'File too large. Maximum size is 5MB.');
            }

            $newName = 'hero_' . time() . '.' . $file->getExtension();
            $uploadPath = FCPATH . 'uploads/images';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $newName);

            // Delete old image if exists
            $oldImage = $this->settingModel->getValue('hero_background_image');
            if ($oldImage && file_exists(FCPATH . ltrim($oldImage, '/'))) {
                unlink(FCPATH . ltrim($oldImage, '/'));
            }

            $this->settingModel->setValue('hero_background_image', '/uploads/images/' . $newName);
        }

        // Handle hero image removal
        if ($this->request->getPost('remove_hero_image') === '1') {
            $oldImage = $this->settingModel->getValue('hero_background_image');
            if ($oldImage && file_exists(FCPATH . ltrim($oldImage, '/'))) {
                unlink(FCPATH . ltrim($oldImage, '/'));
            }
            $this->settingModel->setValue('hero_background_image', '');
        }

        // Save overlay opacity
        $overlayOpacity = $this->request->getPost('hero_overlay_opacity');
        if ($overlayOpacity !== null) {
            $this->settingModel->setValue('hero_overlay_opacity', $overlayOpacity);
        }

        return redirect()->to('/admin/settings')->with('message', 'Settings saved successfully.');
    }
}
