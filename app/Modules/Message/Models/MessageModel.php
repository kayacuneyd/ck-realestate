<?php

namespace App\Modules\Message\Models;

use App\Modules\Message\Entities\Message;
use CodeIgniter\Model;

/**
 * Message Model
 */
class MessageModel extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Message::class;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'reply',
        'replied_at',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]',
        'email' => 'required|valid_email|max_length[255]',
        'message' => 'required|min_length[10]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Please enter your name.',
            'min_length' => 'Name must be at least 2 characters.',
        ],
        'email' => [
            'required' => 'Please enter your email address.',
            'valid_email' => 'Please enter a valid email address.',
        ],
        'message' => [
            'required' => 'Please enter your message.',
            'min_length' => 'Message must be at least 10 characters.',
        ],
    ];

    /**
     * Count unread messages.
     */
    public function countUnread(): int
    {
        return $this->where('status', 'unread')->countAllResults();
    }

    /**
     * Get recent messages.
     */
    public function getRecent(int $limit = 5): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll($limit);
    }

    /**
     * Mark message as read.
     */
    public function markAsRead(int $id): bool
    {
        return $this->update($id, ['status' => 'read']);
    }

    /**
     * Mark message as replied.
     */
    public function markAsReplied(int $id, string $reply): bool
    {
        return $this->update($id, [
            'status' => 'replied',
            'reply' => $reply,
            'replied_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
