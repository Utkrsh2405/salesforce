<?php

use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Create or update admin user with known credentials
$user = User::updateOrCreate(
    ['email' => 'admin@crm.com'],
    [
        'name' => 'CRM Admin',
        'email' => admin@'crm.com',
        'password' => Hash::make('password123'),
        'email_verified_at' => now(),
    ]
);

echo "User created/updated successfully!\n";
echo "Email: admin@crm.com\n";
echo "Password: password123\n";
