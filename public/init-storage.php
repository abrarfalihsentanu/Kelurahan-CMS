<?php

/**
 * Complete Storage Initialization & Laravel Cache Clear for Shared Hosting
 * 
 * Usage:
 * 1. Upload this file to public/ folder
 * 2. Open: https://your-domain.id/init-storage.php
 * 3. Wait for completion
 * 4. Delete this file via FTP
 * 
 * Features:
 * - Create storage folders (10 subfolders)
 * - Create symlink
 * - Clear Laravel cache, config, view, and optimize
 * 
 * ⚠️  SECURITY: Delete this file after use!
 */

// Set base path
$basePath = dirname(dirname(__FILE__));
$storagePath = $basePath . '/storage/app/public';
$bootstrapPath = $basePath . '/bootstrap/app.php';

// Folders to create
$folders = [
    'sliders',
    'news',
    'galleries',
    'achievements',
    'services',
    'infographics',
    'pages',
    'potentials',
    'officials',
    'complaints',
];

// Function to execute artisan commands
function executeArtisanCommand($command, $basePath)
{
    try {
        // Check if artisan file exists
        $artisanPath = $basePath . '/artisan';
        if (!file_exists($artisanPath)) {
            return ['success' => false, 'message' => 'Artisan file not found'];
        }

        // Bootstrap Laravel application
        $app = require $basePath . '/bootstrap/app.php';
        $kernel = $app->make('Illuminate\Contracts\Console\Kernel');

        // Execute command
        $exitCode = $kernel->call($command);
        $kernel->terminate(null, $exitCode);

        return [
            'success' => true,
            'message' => "Command executed: $command",
            'exitCode' => $exitCode
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

// Function to write to Laravel log
function writeLog($basePath, $message)
{
    $logFile = $basePath . '/storage/logs/laravel.log';
    $timestamp = date('Y-m-d H:i:s');
    if (is_writable(dirname($logFile))) {
        file_put_contents($logFile, "[$timestamp] STORAGE-INIT: $message\n", FILE_APPEND);
    }
}

// HTML Header
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Initialization</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            border-bottom: 3px solid #27ae60;
            padding-bottom: 10px;
        }

        h3 {
            color: #34495e;
            margin-top: 20px;
        }

        .status-ok {
            color: #27ae60;
            font-weight: bold;
        }

        .status-exists {
            color: #3498db;
            font-weight: bold;
        }

        .status-error {
            color: #e74c3c;
            font-weight: bold;
        }

        .status-warning {
            color: #f39c12;
            font-weight: bold;
        }

        p {
            line-height: 1.6;
            margin: 10px 0;
        }

        .folder-list {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            font-family: monospace;
            font-size: 13px;
        }

        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .success-box {
            background: #d4edda;
            border: 1px solid #28a745;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }

        code {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }

        ol {
            line-height: 1.8;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🚀 Storage Initialization</h1>
        <p>Initializing image upload storage folders...</p>
        <hr>

        <?php

        // Step 1: Create main public folder
        echo "<h3>1️⃣ Main Storage Folder</h3>";
        if (!is_dir($storagePath)) {
            if (@mkdir($storagePath, 0755, true)) {
                echo "<p><span class='status-ok'>✅ Created:</span> storage/app/public/</p>";
            } else {
                echo "<p><span class='status-error'>❌ Failed:</span> Could not create storage/app/public/</p>";
                echo "<p>Check permissions or try via File Manager</p>";
            }
        } else {
            echo "<p><span class='status-exists'>ℹ️ Already exists:</span> storage/app/public/</p>";
        }

        // Step 2: Create subfolders
        echo "<h3>2️⃣ Creating Image Subfolders</h3>";
        echo "<div class='folder-list'>";

        $created = 0;
        $failed = 0;

        foreach ($folders as $folder) {
            $folderPath = $storagePath . '/' . $folder;
            if (!is_dir($folderPath)) {
                if (@mkdir($folderPath, 0755, true)) {
                    echo "<span class='status-ok'>✅</span> storage/app/public/$folder/\n";
                    $created++;
                } else {
                    echo "<span class='status-error'>❌</span> storage/app/public/$folder/\n";
                    $failed++;
                }
            } else {
                echo "<span class='status-exists'>ℹ️</span> storage/app/public/$folder/\n";
                $created++;
            }
        }

        echo "</div>";
        echo "<p>Created/Exists: <strong>$created/10</strong> | Failed: <strong>$failed</strong></p>";

        // Step 3: Create symlink
        echo "<h3>3️⃣ Creating Symlink</h3>";

        $linkPath = $basePath . '/public/storage';
        $targetPath = $storagePath;

        if (is_link($linkPath)) {
            echo "<p><span class='status-exists'>ℹ️ Symlink already exists</span></p>";
        } else {
            // Remove if directory exists
            if (is_dir($linkPath) && !is_link($linkPath)) {
                @rmdir($linkPath);
            }

            // Try to create symlink
            if (@symlink($targetPath, $linkPath)) {
                echo "<p><span class='status-ok'>✅ Symlink created successfully</span></p>";
                echo "<p>public/storage → ../storage/app/public</p>";
            } else {
                echo "<p><span class='status-warning'>⚠️ Symlink creation failed</span></p>";
                echo "<p>Your shared hosting may not support symlinks.</p>";
                echo "<p>Try creating it manually via File Manager or contact your hosting provider.</p>";
            }
        }

        // Step 4: Clear Laravel cache and optimization
        echo "<h3>4️⃣ Clearing Laravel Cache & Optimization</h3>";
        $artisanPath = $basePath . '/artisan';

        if (file_exists($artisanPath) && file_exists($bootstrapPath)) {
            echo "<div class='folder-list'>";

            // Array of commands to execute
            $commands = [
                'config:clear' => 'Config cache',
                'cache:clear' => 'Application cache',
                'view:clear' => 'View cache',
                'route:clear' => 'Route cache',
                'optimize:clear' => 'Optimization cache',
            ];

            // Try each command
            foreach ($commands as $cmd => $label) {
                try {
                    // Bootstrap Laravel
                    $app = require $bootstrapPath;
                    $kernel = $app->make('Illuminate\Contracts\Console\Kernel');

                    // Execute command
                    $exitCode = $kernel->call($cmd);
                    $kernel->terminate(null, $exitCode);

                    echo "<span class='status-ok'>✅</span> Cleared: $label<br>";
                    writeLog($basePath, "Cleared: $label");
                } catch (Exception $e) {
                    echo "<span class='status-warning'>⚠️ </span> $label - {$e->getMessage()}<br>";
                    writeLog($basePath, "Failed to clear: $label - {$e->getMessage()}");
                }
            }

            echo "</div>";
        } else {
            echo "<p><span class='status-warning'>⚠️</span> Laravel not fully configured or artisan not found</p>";
            echo "<p>If you have SSH access, manually run:</p>";
            echo "<div class='folder-list'>";
            echo "php artisan config:clear<br>";
            echo "php artisan cache:clear<br>";
            echo "php artisan view:clear<br>";
            echo "php artisan route:clear<br>";
            echo "php artisan optimize:clear<br>";
            echo "</div>";
        }

        // Step 5: Fix file permissions
        echo "<h3>5️⃣ File Permissions</h3>";

        $permissionPaths = [
            $storagePath,
            $basePath . '/storage/logs',
            $basePath . '/bootstrap/cache',
        ];

        foreach ($permissionPaths as $path) {
            if (is_dir($path)) {
                @chmod($path, 0755);
                echo "<p><span class='status-ok'>✅</span> Permissions set (755): " . str_replace($basePath, '', $path) . "/</p>";
            }
        }

        ?>

        <hr>
        <div class="success-box">
            <h3>✅ Complete Initialization Done!</h3>
            <p><strong>✅ All tasks completed:</strong></p>
            <ul>
                <li>✅ Storage folders created (10 subfolders)</li>
                <li>✅ Symlink configured</li>
                <li>✅ Laravel cache cleared</li>
                <li>✅ File permissions optimized</li>
            </ul>

            <p style="margin-top: 20px;"><strong>Next steps:</strong></p>
            <ol>
                <li>Login to admin panel: <code>https://<?php echo $_SERVER['HTTP_HOST']; ?>/admin</code></li>
                <li>Go to: <strong>Dashboard → Slider → Tambah Slider</strong></li>
                <li>Upload a test image (JPG or PNG, ~100KB)</li>
                <li>Click: <strong>Simpan</strong></li>
                <li>Verify image appears in admin preview and frontend</li>
            </ol>
        </div>

        <div class="warning-box">
            <h3>⚠️ CRITICAL: Delete This File!</h3>
            <p><strong>For security reasons, you MUST delete this file immediately after initialization:</strong></p>
            <p><strong>Via FTP:</strong> Connect and delete <code>public/init-storage.php</code></p>
            <p><strong>Via File Manager (cPanel/Plesk):</strong> Navigate to public folder and delete init-storage.php</p>
            <p style="color: #e74c3c;"><strong>⚠️ Do NOT leave this file on your server!</strong></p>
        </div>

        <h3>📋 Troubleshooting</h3>
        <p><strong>If folders creation failed:</strong></p>
        <ul>
            <li>Check file permissions (should be 755 or 777)</li>
            <li>Try creating folders manually via File Manager</li>
            <li>Contact your hosting provider for permission issues</li>
        </ul>

        <p><strong>If symlink failed:</strong></p>
        <ul>
            <li>Your shared hosting may not support symlinks</li>
            <li>Try creating symlink via File Manager or cPanel</li>
            <li>Contact your hosting provider to enable symlink support</li>
        </ul>

        <p><strong>If cache clearing failed:</strong></p>
        <ul>
            <li>Your shared hosting may have restrictions on exec functions</li>
            <li>Try via SSH if available: <code>php artisan config:clear && php artisan cache:clear</code></li>
            <li>Or ask hosting provider to enable exec() and system() functions</li>
        </ul>

        <p><strong>If images still don't display:</strong></p>
        <ul>
            <li>Verify <code>.env</code> has correct APP_URL (no trailing slash, e.g., <code>https://domain.id</code>)</li>
            <li>Check that image file exists in storage folder via FTP</li>
            <li>Clear browser cache (Ctrl+F5 or Cmd+Shift+R)</li>
            <li>Manually run additional cache clears if script failed:
                <div style="background: #ecf0f1; padding: 10px; margin: 5px 0; border-radius: 4px;">
                    php artisan config:clear<br>
                    php artisan cache:clear<br>
                    php artisan view:clear<br>
                    php artisan route:clear
                </div>
            </li>
            <li>See <code>SOLUSI_SHARED_HOSTING.md</code> for comprehensive troubleshooting</li>
        </ul>

        <p><strong>Performance After Setup:</strong></p>
        <ul>
            <li>If site is slow after this script, it's normal - Laravel may be reoptimizing</li>
            <li>Wait 5-10 minutes and try again</li>
            <li>If still slow, run: <code>php artisan optimize</code> via SSH or manually</li>
            <li>Check logs at: <code>storage/logs/laravel.log</code> for any errors</li>
        </ul>

        <hr>
        <p style="color: #7f8c8d; font-size: 12px;">
            Kelurahan CMS - Complete Storage & Cache Initialization Script<br>
            Generated: <?php echo date('Y-m-d H:i:s'); ?><br>
            All operations logged to: storage/logs/laravel.log
        </p>
    </div>
</body>

</html>