<?php

namespace App\Modules\OpenImmo\Services;

/**
 * MediaProcessor Service
 * 
 * Handles image extraction from ZIP, optimization,
 * and storage management for OpenImmo imports.
 */
class MediaProcessor
{
    protected string $uploadDir;
    protected array $processedHashes = [];
    protected array $errors = [];

    public function __construct()
    {
        $this->uploadDir = FCPATH . 'uploads/properties';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    /**
     * Process images for a property from extracted ZIP directory.
     * 
     * @param string $extractDir Path to extracted ZIP contents
     * @param string $externalId Property external ID
     * @param array $images Image data from parser
     * @return array Processed image paths
     */
    public function processImages(string $extractDir, string $externalId, array $images): array
    {
        $processedImages = [];
        $propertyDir = $this->uploadDir . '/' . $this->sanitizeFilename($externalId);

        if (!is_dir($propertyDir)) {
            mkdir($propertyDir, 0755, true);
        }

        foreach ($images as $index => $imageData) {
            $result = $this->processImage($extractDir, $propertyDir, $imageData, $index);
            if ($result) {
                $processedImages[] = $result;
            }
        }

        return $processedImages;
    }

    /**
     * Process a single image.
     */
    protected function processImage(string $extractDir, string $propertyDir, array $imageData, int $index): ?string
    {
        $sourcePath = $imageData['path'];
        $location = $imageData['location'] ?? 'INTERN';

        // For REMOTE/EXTERN images, download from URL
        if ($location === 'REMOTE' || $location === 'EXTERN') {
            return $this->downloadImage($sourcePath, $propertyDir, $index);
        }

        // For LOCAL/INTERN images, find in extracted directory
        $fullPath = $this->findImageInZip($extractDir, $sourcePath);

        if (!$fullPath) {
            $this->errors[] = "Image not found in ZIP: {$sourcePath}";
            return null;
        }

        return $this->copyAndOptimize($fullPath, $propertyDir, $index);
    }

    /**
     * Find image file in extracted ZIP (case-insensitive).
     */
    protected function findImageInZip(string $extractDir, string $imagePath): ?string
    {
        // Try direct path
        $fullPath = $extractDir . '/' . $imagePath;
        if (file_exists($fullPath)) {
            return $fullPath;
        }

        // Try with just filename
        $filename = basename($imagePath);

        // Search recursively (case-insensitive)
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($extractDir)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && strcasecmp($file->getFilename(), $filename) === 0) {
                return $file->getPathname();
            }
        }

        return null;
    }

    /**
     * Download image from remote URL.
     */
    protected function downloadImage(string $url, string $propertyDir, int $index): ?string
    {
        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'user_agent' => 'OpenImmo-Importer/1.0',
                ],
            ]);

            $content = @file_get_contents($url, false, $context);

            if ($content === false) {
                $this->errors[] = "Failed to download image: {$url}";
                return null;
            }

            // Determine extension from content type or URL
            $extension = $this->getImageExtension($url, $content);
            $filename = sprintf('image_%02d.%s', $index + 1, $extension);
            $destPath = $propertyDir . '/' . $filename;

            file_put_contents($destPath, $content);

            return $this->optimizeImage($destPath);
        } catch (\Exception $e) {
            $this->errors[] = "Error downloading image: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Copy and optimize local image.
     */
    protected function copyAndOptimize(string $sourcePath, string $propertyDir, int $index): ?string
    {
        // Check hash to avoid reprocessing unchanged images
        $hash = md5_file($sourcePath);

        if (isset($this->processedHashes[$hash])) {
            return $this->processedHashes[$hash];
        }

        // Get extension
        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        if (empty($extension)) {
            $extension = $this->detectImageType($sourcePath);
        }

        // Generate filename
        $filename = sprintf('image_%02d.%s', $index + 1, $extension);
        $destPath = $propertyDir . '/' . $filename;

        // Copy file
        if (!copy($sourcePath, $destPath)) {
            $this->errors[] = "Failed to copy image: {$sourcePath}";
            return null;
        }

        // Optimize
        $finalPath = $this->optimizeImage($destPath);

        if ($finalPath) {
            $this->processedHashes[$hash] = $finalPath;
        }

        return $finalPath;
    }

    /**
     * Optimize image (resize and compress).
     */
    protected function optimizeImage(string $imagePath): ?string
    {
        if (!file_exists($imagePath)) {
            return null;
        }

        // Get image info
        $info = @getimagesize($imagePath);
        if (!$info) {
            return $this->getWebPath($imagePath); // Return as-is if not a valid image
        }

        $width = $info[0];
        $height = $info[1];
        $type = $info[2];

        // Only resize if larger than max dimensions
        $maxWidth = 1920;
        $maxHeight = 1080;

        if ($width <= $maxWidth && $height <= $maxHeight) {
            return $this->getWebPath($imagePath);
        }

        // Load image based on type
        $source = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($imagePath),
            IMAGETYPE_PNG => imagecreatefrompng($imagePath),
            IMAGETYPE_WEBP => imagecreatefromwebp($imagePath),
            IMAGETYPE_GIF => imagecreatefromgif($imagePath),
            default => null,
        };

        if (!$source) {
            return $this->getWebPath($imagePath);
        }

        // Calculate new dimensions
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = (int) ($width * $ratio);
        $newHeight = (int) ($height * $ratio);

        // Create resized image
        $resized = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
        }

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save as JPEG (for file size)
        $jpegPath = preg_replace('/\.[^.]+$/', '.jpg', $imagePath);
        imagejpeg($resized, $jpegPath, 85);

        // Cleanup
        imagedestroy($source);
        imagedestroy($resized);

        // Remove original if different format
        if ($jpegPath !== $imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }

        return $this->getWebPath($jpegPath);
    }

    /**
     * Get web-accessible path from filesystem path.
     */
    protected function getWebPath(string $filePath): string
    {
        return str_replace(FCPATH, '/', $filePath);
    }

    /**
     * Detect image type from content.
     */
    protected function detectImageType(string $filePath): string
    {
        $info = @getimagesize($filePath);

        if (!$info) {
            return 'jpg';
        }

        return match ($info[2]) {
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG => 'png',
            IMAGETYPE_WEBP => 'webp',
            IMAGETYPE_GIF => 'gif',
            default => 'jpg',
        };
    }

    /**
     * Get image extension from URL or content.
     */
    protected function getImageExtension(string $url, string $content): string
    {
        // Try from URL
        $path = parse_url($url, PHP_URL_PATH);
        if ($path) {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return $ext === 'jpeg' ? 'jpg' : $ext;
            }
        }

        // Detect from content
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($content);

        return match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            default => 'jpg',
        };
    }

    /**
     * Sanitize filename for directory name.
     */
    protected function sanitizeFilename(string $filename): string
    {
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);
        return substr($filename, 0, 50);
    }

    /**
     * Get any errors that occurred.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Clear processed hashes cache.
     */
    public function clearCache(): void
    {
        $this->processedHashes = [];
    }
}
