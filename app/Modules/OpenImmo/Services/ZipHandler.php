<?php

namespace App\Modules\OpenImmo\Services;

use CodeIgniter\Files\File;
use RuntimeException;

/**
 * ZipHandler Service
 * 
 * Handles extraction and management of OpenImmo ZIP files
 * containing XML data and media files.
 */
class ZipHandler
{
    protected string $importDir;
    protected string $tempDir;
    protected array $errors = [];

    public function __construct()
    {
        $this->importDir = FCPATH . 'openimmo/import';
        $this->tempDir = WRITEPATH . 'openimmo_temp';

        // Ensure directories exist
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0755, true);
        }
    }

    /**
     * Get list of pending ZIP files in import directory.
     */
    public function getPendingFiles(): array
    {
        if (!is_dir($this->importDir)) {
            return [];
        }

        $files = [];
        foreach (glob($this->importDir . '/*.zip') as $file) {
            // Skip files that are still being uploaded (modified in last 60 seconds)
            if (time() - filemtime($file) < 60) {
                continue;
            }
            $files[] = $file;
        }

        return $files;
    }

    /**
     * Extract a ZIP file to temp directory.
     * 
     * @param string $zipPath Full path to ZIP file
     * @return string|false Path to extracted directory or false on failure
     */
    public function extract(string $zipPath)
    {
        if (!file_exists($zipPath)) {
            $this->errors[] = "ZIP file not found: {$zipPath}";
            return false;
        }

        $zip = new \ZipArchive();
        $result = $zip->open($zipPath);

        if ($result !== true) {
            $this->errors[] = "Failed to open ZIP: {$zipPath} (Error code: {$result})";
            return false;
        }

        // Create unique extraction directory
        $extractDir = $this->tempDir . '/' . uniqid('import_');

        if (!$zip->extractTo($extractDir)) {
            $this->errors[] = "Failed to extract ZIP: {$zipPath}";
            $zip->close();
            return false;
        }

        $zip->close();
        return $extractDir;
    }

    /**
     * Find the OpenImmo XML file in an extracted directory.
     */
    public function findXmlFile(string $extractDir): ?string
    {
        // Look for XML files
        $xmlFiles = glob($extractDir . '/*.xml');

        if (empty($xmlFiles)) {
            // Check subdirectories
            $xmlFiles = glob($extractDir . '/*/*.xml');
        }

        foreach ($xmlFiles as $xmlFile) {
            // Verify it's an OpenImmo file by checking root element
            $content = file_get_contents($xmlFile, false, null, 0, 1000);
            if (strpos($content, '<openimmo') !== false) {
                return $xmlFile;
            }
        }

        $this->errors[] = "No OpenImmo XML file found in extracted directory";
        return null;
    }

    /**
     * Clean up extracted temporary directory.
     */
    public function cleanup(string $extractDir): void
    {
        if (is_dir($extractDir) && strpos($extractDir, $this->tempDir) === 0) {
            $this->deleteDirectory($extractDir);
        }
    }

    /**
     * Move processed ZIP to archive folder.
     */
    public function archive(string $zipPath): void
    {
        $archiveDir = $this->importDir . '/processed';
        if (!is_dir($archiveDir)) {
            mkdir($archiveDir, 0755, true);
        }

        $filename = basename($zipPath);
        $archivePath = $archiveDir . '/' . date('Y-m-d_H-i-s') . '_' . $filename;

        rename($zipPath, $archivePath);
    }

    /**
     * Get any errors that occurred.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Recursively delete a directory.
     */
    protected function deleteDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }
        rmdir($dir);
    }

    /**
     * Get the import directory path.
     */
    public function getImportDir(): string
    {
        return $this->importDir;
    }

    /**
     * Get the temp directory path.
     */
    public function getTempDir(): string
    {
        return $this->tempDir;
    }
}
