<?php

namespace App\Modules\Page\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Page Entity
 */
class Page extends Entity
{
    protected $attributes = [
        'id' => null,
        'title' => null,
        'slug' => null,
        'content' => null,
        'meta_title' => null,
        'meta_description' => null,
        'is_active' => true,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function isActive(): bool
    {
        return (bool) $this->attributes['is_active'];
    }
}
