<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * ContentBlock Model
 * 
 * Manages editable content blocks for CMS functionality.
 * Content is organized by page and block_key.
 */
class ContentBlockModel extends Model
{
    protected $table = 'content_blocks';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'page',
        'block_key',
        'content',
        'content_type',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get content block by page and key.
     */
    public function getContent(string $page, string $key, string $default = ''): string
    {
        $block = $this->where('page', $page)
            ->where('block_key', $key)
            ->first();

        return $block['content'] ?? $default;
    }

    /**
     * Set or update content block.
     */
    public function setContent(string $page, string $key, string $content, string $type = 'text'): bool
    {
        $existing = $this->where('page', $page)
            ->where('block_key', $key)
            ->first();

        if ($existing) {
            return $this->update($existing['id'], [
                'content' => $content,
                'content_type' => $type,
            ]);
        }

        return $this->insert([
            'page' => $page,
            'block_key' => $key,
            'content' => $content,
            'content_type' => $type,
        ]) !== false;
    }

    /**
     * Get all content blocks for a page.
     */
    public function getPageContent(string $page): array
    {
        $blocks = $this->where('page', $page)->findAll();

        $result = [];
        foreach ($blocks as $block) {
            $result[$block['block_key']] = $block['content'];
        }

        return $result;
    }

    /**
     * Get all pages that have content.
     */
    public function getPages(): array
    {
        return $this->select('page')
            ->distinct()
            ->findAll();
    }

    /**
     * Initialize default content for a page if not exists.
     */
    public function initDefaults(string $page, array $defaults): void
    {
        foreach ($defaults as $key => $content) {
            $existing = $this->where('page', $page)
                ->where('block_key', $key)
                ->first();

            if (!$existing) {
                $this->insert([
                    'page' => $page,
                    'block_key' => $key,
                    'content' => $content,
                    'content_type' => 'text',
                ]);
            }
        }
    }
}
