<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminUser extends Command
{
    protected $signature = 'admin:reset';
    protected $description = 'Reset admin user credentials untuk testing';

    public function handle()
    {
        // Hapus user admin lama jika ada
        User::where('email', 'admin@kelurahan-petamburan.go.id')->delete();

        // Buat user admin baru
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@kelurahan-petamburan.go.id',
            'password' => Hash::make('password'),
            'is_active' => true,
            'is_admin' => true,
        ]);

        $this->info('✅ Admin user berhasil dibuat!');
        $this->info('');
        $this->info('📧 Email: admin@kelurahan-petamburan.go.id');
        $this->info('🔐 Password: password');
        $this->info('');
        $this->info('Silakan gunakan kredensial tersebut untuk login di http://kelurahan-cms.test/login');

        return Command::SUCCESS;
    }
}
