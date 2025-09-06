<?php

namespace Database\Seeders;

use App\Models\LeadStatus;
use Illuminate\Database\Seeder;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'New', 'description' => 'Newly created lead', 'color' => '#6c757d'],
            ['name' => 'Contacted', 'description' => 'Initial contact made', 'color' => '#007bff'],
            ['name' => 'Qualified', 'description' => 'Lead has been qualified', 'color' => '#17a2b8'],
            ['name' => 'Proposal Sent', 'description' => 'Proposal has been sent', 'color' => '#ffc107'],
            ['name' => 'Negotiation', 'description' => 'In negotiation phase', 'color' => '#fd7e14'],
            ['name' => 'Converted', 'description' => 'Lead converted to deal', 'color' => '#28a745'],
            ['name' => 'Lost', 'description' => 'Lead was lost', 'color' => '#dc3545'],
        ];

        foreach ($statuses as $status) {
            LeadStatus::firstOrCreate(['name' => $status['name']], $status);
        }
    }
}
