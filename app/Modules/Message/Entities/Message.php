<?php

namespace App\Modules\Message\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Message Entity
 */
class Message extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'email' => null,
        'phone' => null,
        'subject' => null,
        'message' => null,
        'status' => 'unread',
        'reply' => null,
        'replied_at' => null,
        'created_at' => null,
        'updated_at' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'updated_at', 'replied_at'];

    /**
     * Check if message is unread.
     */
    public function isUnread(): bool
    {
        return $this->attributes['status'] === 'unread';
    }

    /**
     * Check if message has been replied to.
     */
    public function isReplied(): bool
    {
        return $this->attributes['status'] === 'replied';
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->attributes['status']) {
            'unread' => 'bg-danger',
            'read' => 'bg-secondary',
            'replied' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    /**
     * Get status label.
     */
    public function getStatusLabel(): string
    {
        return match ($this->attributes['status']) {
            'unread' => 'Unread',
            'read' => 'Read',
            'replied' => 'Replied',
            default => 'Unknown',
        };
    }
}
