<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InitializeStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize storage folders for image uploads';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Initializing Storage Folders...');
        $this->newLine();

        // List of folders that need to be created
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

        $storagePath = storage_path('app/public');

        // Create main public storage folder if not exists
        if (!File::isDirectory($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
            $this->info("✅ Created: storage/app/public/");
        }

        // Create all subfolders
        $this->info('Creating image storage subdirectories...');
        foreach ($folders as $folder) {
            $folderPath = $storagePath . '/' . $folder;
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
                $this->line("  ✅ Created: storage/app/public/{$folder}/");
            } else {
                $this->line("  ℹ️  Exists:  storage/app/public/{$folder}/");
            }
        }

        // Create symlink
        $this->newLine();
        $this->info('Creating storage symlink...');

        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');

        if (File::isLink($linkPath)) {
            $this->line("  ℹ️  Symlink already exists");
        } else {
            if (File::exists($linkPath)) {
                File::deleteDirectory($linkPath);
            }
            symlink($targetPath, $linkPath);
            $this->line("  ✅ Symlink created: public/storage");
        }

        // Clear cache
        $this->newLine();
        $this->info('Clearing Laravel cache...');

        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('optimize:clear');

        // Verification
        $this->newLine();
        $this->info('📋 Verification:');

        $allExists = true;
        foreach ($folders as $folder) {
            $folderPath = $storagePath . '/' . $folder;
            if (File::isDirectory($folderPath)) {
                $this->line("  ✅ {$folder}/");
            } else {
                $this->line("  ❌ {$folder}/ (MISSING)");
                $allExists = false;
            }
        }

        // Final message
        $this->newLine();
        if ($allExists && File::isLink($linkPath)) {
            $this->info('✅ Storage initialization complete!');
            $this->line('Ready to upload images in all modules.');
        } else {
            $this->warn('⚠️  Some folders or symlink may not be properly created.');
            $this->warn('Check permissions: sudo chown -R www-data:www-data storage/');
        }
    }
}
