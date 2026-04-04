<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

/**
 * FileValidator - Comprehensive file upload validation
 * Checks MIME type, file magic bytes, size, and extensions
 */
class FileValidator
{
    /**
     * Allowed MIME types for different file categories
     */
    private static array $allowedMimes = [
        'image' => [
            'image/jpeg' => ['jpg', 'jpeg'],
            'image/png' => ['png'],
            'image/webp' => ['webp'],
            'image/gif' => ['gif'],
            'image/svg+xml' => ['svg'],
        ],
        'document' => [
            'application/pdf' => ['pdf'],
            'application/msword' => ['doc'],
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => ['docx'],
            'application/vnd.ms-excel' => ['xls'],
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => ['xlsx'],
        ],
        'archive' => [
            'application/zip' => ['zip'],
            'application/x-rar-compressed' => ['rar'],
            'application/x-7z-compressed' => ['7z'],
        ],
    ];

    /**
     * Magic bytes (file signatures) for validation
     */
    private static array $magicBytes = [
        'jpg' => ['FF', 'D8', 'FF'],
        'jpeg' => ['FF', 'D8', 'FF'],
        'png' => ['89', '50', '4E', '47'],
        'gif' => ['47', '49', '46'],
        'pdf' => ['25', '50', '44', '46'],
        'zip' => ['50', '4B', '03', '04'],
        'webp' => ['52', '49', '46', '46'],
    ];

    /**
     * Validate uploaded file
     * 
     * @param UploadedFile $file
     * @param string $category 'image', 'document', or 'archive'
     * @param int $maxSizeInKB Maximum file size in kilobytes
     * @return array ['valid' => true/false, 'errors' => []]
     */
    public static function validate(UploadedFile $file, string $category = 'image', int $maxSizeInKB = 2048): array
    {
        $errors = [];

        // Check if category is valid
        if (!isset(self::$allowedMimes[$category])) {
            return [
                'valid' => false,
                'errors' => ["Invalid category: $category"],
            ];
        }

        // Check file size
        $fileSizeInKB = $file->getSize() / 1024;
        if ($fileSizeInKB > $maxSizeInKB) {
            $errors[] = "File size exceeds maximum allowed size of {$maxSizeInKB}KB";
        }

        // Check MIME type
        $mimeType = $file->getMimeType();
        if (!self::isAllowedMimeType($mimeType, $category)) {
            $errors[] = "File type '$mimeType' is not allowed for $category";
        }

        // Check file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!self::isAllowedExtension($extension, $category)) {
            $errors[] = "File extension '.$extension' is not allowed for $category";
        }

        // Check magic bytes (file signature)
        if (!self::validateMagicBytes($file, $extension)) {
            $errors[] = "File content does not match the file extension (possible file type spoofing)";
        }

        // Check for dangerous content
        if (self::containsDangerousContent($file, $extension)) {
            $errors[] = "File contains potentially dangerous content";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Check if MIME type is allowed for category
     */
    private static function isAllowedMimeType(string $mimeType, string $category): bool
    {
        return isset(self::$allowedMimes[$category][$mimeType]);
    }

    /**
     * Check if extension is allowed for category
     */
    private static function isAllowedExtension(string $extension, string $category): bool
    {
        foreach (self::$allowedMimes[$category] as $extensions) {
            if (in_array($extension, $extensions, true)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Validate file magic bytes to prevent spoofing
     */
    private static function validateMagicBytes(UploadedFile $file, string $extension): bool
    {
        if (!isset(self::$magicBytes[$extension])) {
            return true; // No magic bytes defined for this type, skip check
        }

        $handle = fopen($file->getRealPath(), 'rb');
        if (!$handle) {
            return false;
        }

        $magicBytes = [];
        for ($i = 0; $i < 4; $i++) {
            $byte = fread($handle, 1);
            if ($byte === false) {
                break;
            }
            $magicBytes[] = strtoupper(dechex(ord($byte)));
        }
        fclose($handle);

        $expectedMagic = self::$magicBytes[$extension];
        foreach ($expectedMagic as $i => $byte) {
            if (!isset($magicBytes[$i]) || $magicBytes[$i] !== $byte) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check for dangerous content in file (e.g., embedded scripts in SVG)
     */
    private static function containsDangerousContent(UploadedFile $file, string $extension): bool
    {
        if ($extension === 'svg') {
            $content = file_get_contents($file->getRealPath());
            if (preg_match('/<script|javascript:|on\w+\s*=/i', $content)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get file category by MIME type
     */
    public static function getCategoryByMimeType(string $mimeType): ?string
    {
        foreach (self::$allowedMimes as $category => $mimes) {
            if (isset($mimes[$mimeType])) {
                return $category;
            }
        }
        return null;
    }

    /**
     * Sanitize filename
     */
    public static function sanitizeFilename(string $filename): string
    {
        // Remove special characters but keep extension
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Remove/replace dangerous characters
        $name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $name);
        // Remove multiple underscores
        $name = preg_replace('/_+/', '_', $name);
        // Limit length
        $name = substr($name, 0, 200);

        return $name . '.' . $extension;
    }
}
