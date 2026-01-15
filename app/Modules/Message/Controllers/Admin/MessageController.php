<?php

namespace App\Modules\Message\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\Message\Models\MessageModel;
use App\Modules\Message\Services\ResendService;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Admin Message Controller
 * 
 * Handles all admin operations for messages.
 */
class MessageController extends BaseController
{
    protected MessageModel $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessageModel();
    }

    /**
     * Display all messages.
     */
    public function index(): string
    {
        $status = $this->request->getGet('status');

        $builder = $this->messageModel->builder()->orderBy('created_at', 'DESC');

        if ($status && in_array($status, ['unread', 'read', 'replied'])) {
            $builder->where('status', $status);
        }

        $data = [
            'title' => 'Messages',
            'messages' => $builder->get()->getResult($this->messageModel->returnType),
            'unreadCount' => $this->messageModel->countUnread(),
            'currentFilter' => $status,
        ];

        return view('App\Modules\Message\Views\admin\index', $data);
    }

    /**
     * Show a single message.
     */
    public function show(int $id): string|RedirectResponse
    {
        $message = $this->messageModel->find($id);

        if (!$message) {
            return redirect()->to('/admin/messages')
                ->with('error', 'Message not found.');
        }

        // Mark as read if unread
        if ($message->status === 'unread') {
            $this->messageModel->markAsRead($id);
            $message->status = 'read';
        }

        $data = [
            'title' => 'View Message',
            'message' => $message,
        ];

        return view('App\Modules\Message\Views\admin\show', $data);
    }

    /**
     * Send a reply to the message.
     */
    public function reply(int $id): RedirectResponse
    {
        $message = $this->messageModel->find($id);

        if (!$message) {
            return redirect()->to('/admin/messages')
                ->with('error', 'Message not found.');
        }

        $replyText = trim($this->request->getPost('reply'));

        if (empty($replyText)) {
            return redirect()->back()
                ->with('error', 'Reply message cannot be empty.');
        }

        // Update message status
        $this->messageModel->markAsReplied($id, $replyText);

        // Send reply email to customer
        $resend = new ResendService();
        $emailResult = $resend->sendReplyNotification(
            $message->email,
            $message->name,
            $message->message,
            $replyText
        );

        if ($emailResult['success']) {
            return redirect()->to('/admin/messages')
                ->with('message', 'Reply sent successfully to ' . $message->email);
        } else {
            return redirect()->to('/admin/messages')
                ->with('warning', 'Reply saved but email delivery failed. Error: ' . ($emailResult['error'] ?? 'Unknown'));
        }
    }

    /**
     * Delete a message.
     */
    public function delete(int $id): RedirectResponse
    {
        $message = $this->messageModel->find($id);

        if (!$message) {
            return redirect()->to('/admin/messages')
                ->with('error', 'Message not found.');
        }

        $this->messageModel->delete($id);

        return redirect()->to('/admin/messages')
            ->with('message', 'Message deleted successfully.');
    }
}
