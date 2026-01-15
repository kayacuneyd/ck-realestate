<?php

namespace App\Modules\Message\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Modules\Message\Models\MessageModel;
use App\Modules\Message\Services\ResendService;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Contact Form Controller
 * 
 * Handles contact form submissions from the frontend.
 */
class ContactController extends BaseController
{
    protected MessageModel $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessageModel();
    }

    /**
     * Handle contact form submission.
     */
    public function send(): RedirectResponse
    {
        $data = [
            'name' => trim($this->request->getPost('name')),
            'email' => trim($this->request->getPost('email')),
            'phone' => trim($this->request->getPost('phone') ?? ''),
            'subject' => trim($this->request->getPost('subject') ?? 'Contact Form Inquiry'),
            'message' => trim($this->request->getPost('message')),
            'status' => 'unread',
        ];

        // Validate and save
        if (!$this->messageModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was a problem sending your message. Please check the form and try again.')
                ->with('errors', $this->messageModel->errors());
        }

        // Send email notification to admin
        $resend = new ResendService();
        $emailResult = $resend->sendNewMessageNotification($data);

        if (!$emailResult['success']) {
            log_message('warning', 'Failed to send email notification: ' . ($emailResult['error'] ?? 'Unknown error'));
        }

        return redirect()->to('/contact')
            ->with('success', 'Thank you for your message! We will get back to you as soon as possible.');
    }
}
