<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class LoginDiagnostic extends Command
{
    protected $signature = 'login:diagnostic';
    protected $description = 'Check login system status dan troubleshoot issues';

    public function handle()
    {
        $this->info('🔍 Login System Diagnostic');
        $this->info('═══════════════════════════════════════');
        $this->newLine();

        // 1. Check admin users
        $adminUsers = User::where('is_admin', true)->get();
        $this->info("📋 Admin Users dalam database: " . $adminUsers->count());

        if ($adminUsers->count() > 0) {
            foreach ($adminUsers as $user) {
                $status = $user->is_active ? '✅ Active' : '❌ Inactive';
                $this->info("   • {$user->name} ({$user->email}) - $status");
            }
        } else {
            $this->warn("   ⚠️  Tidak ada admin user!");
        }
        $this->newLine();

        // 2. Check total users
        $totalUsers = User::count();
        $this->info("👥 Total users dalam database: $totalUsers");
        $this->newLine();

        // 3. Check environment
        $appUrl = config('app.url');
        $appDebug = config('app.debug') ? 'Enabled' : 'Disabled';
        $this->info("⚙️  Konfigurasi Aplikasi:");
        $this->info("   • APP_URL: $appUrl");
        $this->info("   • APP_DEBUG: $appDebug");
        $this->newLine();

        // 4. Instructions
        $this->info("📝 Instruksi Login:");
        $this->line("   1. Kunjungi: $appUrl/login");
        $this->line("   2. Gunakan kredensial:");
        $this->line("      📧 Email: admin@kelurahan-petamburan.go.id");
        $this->line("      🔐 Password: password");
        $this->newLine();

        // 5. Troubleshooting
        $this->info("🔧 Troubleshooting:");
        if ($adminUsers->count() == 0) {
            $this->warn("   ⚠️  Tidak ada admin user! Jalankan: php artisan admin:reset");
        } elseif ($adminUsers->where('is_active', false)->count() > 0) {
            $this->warn("   ⚠️  Ada admin user yang inactive! Jalankan: php artisan admin:reset");
        } else {
            $this->info("   ✅ Setup sudah benar. Coba login di $appUrl/login");
        }

        $this->newLine();
        $this->info("═══════════════════════════════════════");
        return Command::SUCCESS;
    }
}
