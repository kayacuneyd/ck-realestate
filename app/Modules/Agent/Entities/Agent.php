<?php

namespace App\Modules\Agent\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Agent Entity
 */
class Agent extends Entity
{
    /**
     * Default values.
     */
    protected $attributes = [
        'id' => null,
        'name' => null,
        'slug' => null,
        'title' => null,
        'bio' => null,
        'photo' => null,
        'phone' => null,
        'email' => null,
        'is_active' => true,
        'sort_order' => 0,
        'created_at' => null,
        'updated_at' => null,
    ];

    /**
     * Type casting.
     */
    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * Check if agent is active.
     */
    public function isActive(): bool
    {
        return (bool) $this->attributes['is_active'];
    }
}
