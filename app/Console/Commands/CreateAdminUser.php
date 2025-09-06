<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'user:create-admin';
    protected $description = 'Create an admin user';

    public function handle()
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@crm.com'],
            [
                'name' => 'CRM Admin',
                'email' => 'admin@crm.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $this->info('Admin user created successfully!');
        $this->info('Email: admin@crm.com');
        $this->info('Password: password123');
    }
}
