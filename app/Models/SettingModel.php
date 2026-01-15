<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Settings Model
 * 
 * Manages key-value site settings stored in the database.
 */
class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['key', 'value', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    /**
     * Get a setting value by key.
     */
    public function getValue(string $key, $default = null)
    {
        $setting = $this->where('key', $key)->first();
        return $setting ? $setting['value'] : $default;
    }

    /**
     * Set a setting value by key.
     */
    public function setValue(string $key, $value): bool
    {
        $existing = $this->where('key', $key)->first();

        if ($existing) {
            return $this->update($existing['id'], ['value' => $value]);
        }

        return $this->insert(['key' => $key, 'value' => $value]) !== false;
    }

    /**
     * Get multiple settings at once.
     */
    public function getMultiple(array $keys): array
    {
        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = $this->get($key);
        }
        return $settings;
    }

    /**
     * Set multiple settings at once.
     */
    public function setMultiple(array $data): bool
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
        return true;
    }
}
