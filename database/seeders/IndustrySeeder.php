<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industries = [
            ['name' => 'Technology', 'description' => 'Software, hardware, and IT services'],
            ['name' => 'Healthcare', 'description' => 'Medical, pharmaceutical, and health services'],
            ['name' => 'Finance', 'description' => 'Banking, insurance, and financial services'],
            ['name' => 'Manufacturing', 'description' => 'Production and manufacturing companies'],
            ['name' => 'Retail', 'description' => 'Retail and e-commerce businesses'],
            ['name' => 'Education', 'description' => 'Educational institutions and services'],
            ['name' => 'Real Estate', 'description' => 'Property development and real estate services'],
            ['name' => 'Construction', 'description' => 'Construction and building services'],
            ['name' => 'Transportation', 'description' => 'Logistics, shipping, and transportation'],
            ['name' => 'Energy', 'description' => 'Oil, gas, renewable energy companies'],
            ['name' => 'Telecommunications', 'description' => 'Telecom and communication services'],
            ['name' => 'Entertainment', 'description' => 'Media, entertainment, and gaming'],
            ['name' => 'Food & Beverage', 'description' => 'Food production and restaurant industry'],
            ['name' => 'Automotive', 'description' => 'Car manufacturing and automotive services'],
            ['name' => 'Agriculture', 'description' => 'Farming and agricultural businesses'],
            ['name' => 'Consulting', 'description' => 'Professional consulting services'],
            ['name' => 'Non-Profit', 'description' => 'Non-profit organizations and charities'],
            ['name' => 'Government', 'description' => 'Government agencies and public sector'],
            ['name' => 'Travel & Tourism', 'description' => 'Travel, hospitality, and tourism'],
            ['name' => 'Other', 'description' => 'Other industries not listed above'],
        ];

        foreach ($industries as $industry) {
            Industry::firstOrCreate(['name' => $industry['name']], $industry);
        }
    }
}
