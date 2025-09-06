<?php

namespace Database\Seeders;

use App\Models\Industry;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\DealStage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create industries
        $industries = [
            'Technology',
            'Healthcare',
            'Finance',
            'Manufacturing',
            'Retail',
            'Education',
            'Real Estate',
            'Professional Services',
            'Telecommunications',
            'Energy'
        ];

        foreach ($industries as $industry) {
            Industry::create(['name' => $industry]);
        }

        // Create lead sources
        $leadSources = [
            'Website',
            'Referral',
            'Social Media',
            'Trade Show',
            'Email Campaign',
            'Cold Call',
            'Advertisement',
            'Partner',
            'Other'
        ];

        foreach ($leadSources as $source) {
            LeadSource::create(['name' => $source]);
        }

        // Create lead statuses
        $leadStatuses = [
            ['name' => 'New', 'order' => 1, 'color' => '#3498db'],
            ['name' => 'Contacted', 'order' => 2, 'color' => '#f1c40f'],
            ['name' => 'Qualified', 'order' => 3, 'color' => '#2ecc71'],
            ['name' => 'Proposal', 'order' => 4, 'color' => '#9b59b6'],
            ['name' => 'Negotiation', 'order' => 5, 'color' => '#e67e22'],
            ['name' => 'Closed Won', 'order' => 6, 'color' => '#27ae60'],
            ['name' => 'Closed Lost', 'order' => 7, 'color' => '#e74c3c']
        ];

        foreach ($leadStatuses as $status) {
            LeadStatus::create($status);
        }

        // Create deal stages
        $dealStages = [
            ['name' => 'Discovery', 'probability' => 20, 'order' => 1, 'color' => '#3498db'],
            ['name' => 'Qualified', 'probability' => 40, 'order' => 2, 'color' => '#f1c40f'],
            ['name' => 'Proposal', 'probability' => 60, 'order' => 3, 'color' => '#2ecc71'],
            ['name' => 'Negotiation', 'probability' => 80, 'order' => 4, 'color' => '#9b59b6'],
            ['name' => 'Closed Won', 'probability' => 100, 'order' => 5, 'color' => '#27ae60'],
            ['name' => 'Closed Lost', 'probability' => 0, 'order' => 6, 'color' => '#e74c3c']
        ];

        foreach ($dealStages as $stage) {
            DealStage::create($stage);
        }
    }
}
