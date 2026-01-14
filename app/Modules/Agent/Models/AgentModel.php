<?php

namespace App\Modules\Agent\Models;

use CodeIgniter\Model;
use App\Modules\Agent\Entities\Agent;

/**
 * AgentModel
 */
class AgentModel extends Model
{
    protected $table = 'agents';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Agent::class;
    protected $useSoftDeletes = false;

    /**
     * Fields that are allowed to be mass-assigned.
     */
    protected $allowedFields = [
        'name',
        'slug',
        'title',
        'bio',
        'photo',
        'phone',
        'email',
        'is_active',
        'sort_order',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    /**
     * Validation rules.
     */
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'email' => 'required|valid_email|is_unique[agents.email,id,{id}]',
        'phone' => 'permit_empty|min_length[10]|max_length[20]',
        'is_active' => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email address is already in use.',
        ],
    ];

    protected $skipValidation = false;
}
