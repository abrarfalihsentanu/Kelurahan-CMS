<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class StorageHelper
{
    /**
     * Copy uploaded file from storage/app/public to public_html/storage
     * for shared hosting compatibility
     * 
     * @param string $storagePath Path in storage/app/public
     * @param string $subfolder Subfolder name (e.g., 'sliders', 'news')
     * @return bool Success status
     */
    public static function copyToPublic($storagePath, $subfolder)
    {
        try {
            // Full storage path
            $fullStoragePath = storage_path('app/public/' . $storagePath);

            // Target path in public/storage
            $publicPath = public_path('storage/' . $storagePath);

            // Ensure public_html/storage folder exists
            if (!File::exists(dirname($publicPath))) {
                File::makeDirectory(dirname($publicPath), 0755, true);
            }

            // Copy file
            if (File::exists($fullStoragePath)) {
                File::copy($fullStoragePath, $publicPath);
                return true;
            }

            return false;
        } catch (\Exception $e) {
            // Log error if needed
            \Log::warning('StorageHelper::copyToPublic failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete file from both storage and public paths
     * 
     * @param string $filePath Path stored in database
     * @return bool Success status
     */
    public static function deleteFromBoth($filePath)
    {
        try {
            // Delete from storage/app/public
            $storagePath = storage_path('app/public/' . $filePath);
            if (File::exists($storagePath)) {
                File::delete($storagePath);
            }

            // Delete from public/storage
            $publicPath = public_path('storage/' . $filePath);
            if (File::exists($publicPath)) {
                File::delete($publicPath);
            }

            return true;
        } catch (\Exception $e) {
            \Log::warning('StorageHelper::deleteFromBoth failed: ' . $e->getMessage());
            return false;
        }
    }
}
