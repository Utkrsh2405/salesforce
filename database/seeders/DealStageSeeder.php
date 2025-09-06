<?php

namespace Database\Seeders;

use App\Models\DealStage;
use Illuminate\Database\Seeder;

class DealStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            ['name' => 'Prospecting', 'description' => 'Initial prospecting stage', 'probability' => 10, 'order' => 1, 'color' => '#6c757d'],
            ['name' => 'Qualification', 'description' => 'Qualifying the opportunity', 'probability' => 25, 'order' => 2, 'color' => '#007bff'],
            ['name' => 'Needs Analysis', 'description' => 'Analyzing customer needs', 'probability' => 40, 'order' => 3, 'color' => '#17a2b8'],
            ['name' => 'Proposal', 'description' => 'Proposal sent to customer', 'probability' => 60, 'order' => 4, 'color' => '#ffc107'],
            ['name' => 'Negotiation', 'description' => 'Negotiating terms', 'probability' => 80, 'order' => 5, 'color' => '#fd7e14'],
            ['name' => 'Closed Won', 'description' => 'Deal successfully closed', 'probability' => 100, 'order' => 6, 'color' => '#28a745'],
            ['name' => 'Closed Lost', 'description' => 'Deal was lost', 'probability' => 0, 'order' => 7, 'color' => '#dc3545'],
        ];

        foreach ($stages as $stage) {
            DealStage::firstOrCreate(['name' => $stage['name']], $stage);
        }
    }
}
