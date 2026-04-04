<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get URL untuk gambar dengan fallback support
     * Mendukung: symlink, storage alias, dan direct path
     * 
     * Usage: {{ imageUrl($model->image) }}
     */
    public static function url($path)
    {
        if (empty($path)) {
            return null;
        }

        // Coba priority 1: Storage::url (untuk symlink)
        $storageUrl = Storage::url($path);

        // Priority 2: Direct asset path (fallback)
        $assetUrl = asset('storage/' . $path);

        // Gunakan yang pertama kali berhasil
        // Default ke Storage::url dulu (production priority)
        return $storageUrl ?: $assetUrl;
    }

    /**
     * Placeholder gambar jika file tidak ada
     */
    public static function placeholder($width = 100, $height = 100, $bg = '#e3e3e3', $text = 'No Image')
    {
        return "https://via.placeholder.com/{$width}x{$height}/{$bg}?text=" . urlencode($text);
    }

    /**
     * Check apakah file gambar ada
     */
    public static function exists($path)
    {
        return !empty($path) && Storage::disk('public')->exists($path);
    }

    /**
     * Get gambar dengan fallback ke placeholder
     */
    public static function urlOrPlaceholder($path, $width = 100, $height = 100)
    {
        return self::exists($path) ? self::url($path) : self::placeholder($width, $height);
    }
}
