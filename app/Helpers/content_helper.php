<?php

/**
 * Content Helper Functions
 * 
 * Helper functions for retrieving editable content blocks.
 */

if (!function_exists('content')) {
    /**
     * Get content block value.
     * 
     * @param string $page Page identifier
     * @param string $key Block key
     * @param string $default Default value if not found
     * @return string
     */
    function content(string $page, string $key, string $default = ''): string
    {
        static $cache = [];

        $cacheKey = "{$page}.{$key}";

        if (!isset($cache[$cacheKey])) {
            $model = new \App\Models\ContentBlockModel();
            $cache[$cacheKey] = $model->getContent($page, $key, $default);
        }

        return $cache[$cacheKey];
    }
}

if (!function_exists('page_content')) {
    /**
     * Get all content blocks for a page.
     * 
     * @param string $page Page identifier
     * @return array
     */
    function page_content(string $page): array
    {
        $model = new \App\Models\ContentBlockModel();
        return $model->getPageContent($page);
    }
}
