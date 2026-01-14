<?php

namespace App\Modules\Page\Models;

use CodeIgniter\Model;
use App\Modules\Page\Entities\Page;

/**
 * PageModel
 */
class PageModel extends Model
{
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Page::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'slug' => 'required|alpha_dash|is_unique[pages.slug,id,{id}]',
        'content' => 'required',
    ];
}
