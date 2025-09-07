<?php

namespace Database\Seeders;

use App\Models\TaxExemptionType;
use App\Models\TaxRate;
use Illuminate\Database\Seeder;

class TaxDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tax exemption types
        $exemptionTypes = [
            ['name' => 'Life Insurance Premium', 'code' => 'LIFE_INSURANCE', 'max_amount' => 60000, 'is_active' => true],
            ['name' => 'Contribution to Provident Fund', 'code' => 'PROVIDENT_FUND', 'max_amount' => 60000, 'is_active' => true],
            ['name' => 'Investment in Approved Savings Certificate', 'code' => 'SAVINGS_CERT', 'max_amount' => 200000, 'is_active' => true],
            ['name' => 'Investment in Approved Debenture or Debenture Stock', 'code' => 'DEBENTURE', 'max_amount' => 25000, 'is_active' => true],
            ['name' => 'Contribution to Deposit Pension Scheme', 'code' => 'PENSION_SCHEME', 'max_amount' => 60000, 'is_active' => true],
            ['name' => 'Contribution to Benevolent Fund and Group Insurance', 'code' => 'BENEVOLENT_FUND', 'max_amount' => 60000, 'is_active' => true],
            ['name' => 'Contribution to Zakat Fund', 'code' => 'ZAKAT', 'max_amount' => null, 'is_active' => true],
            ['name' => 'Donation to Approved Charitable Institutions', 'code' => 'DONATION', 'max_amount' => 1200000, 'is_active' => true],
        ];

        foreach ($exemptionTypes as $type) {
            TaxExemptionType::updateOrCreate(
                ['code' => $type['code']],
                $type
            );
        }

        // Tax rates for individuals (FY 2023-2024)
        $individualRates = [
            ['min_income' => 0, 'max_income' => 350000, 'rate' => 0, 'filing_type' => 'individual'],
            ['min_income' => 350001, 'max_income' => 450000, 'rate' => 5, 'filing_type' => 'individual'],
            ['min_income' => 450001, 'max_income' => 750000, 'rate' => 10, 'filing_type' => 'individual'],
            ['min_income' => 750001, 'max_income' => 1150000, 'rate' => 15, 'filing_type' => 'individual'],
            ['min_income' => 1150001, 'max_income' => 1650000, 'rate' => 20, 'filing_type' => 'individual'],
            ['min_income' => 1650001, 'max_income' => null, 'rate' => 25, 'filing_type' => 'individual'],
        ];

        // Tax rates for businesses (FY 2023-2024)
        $businessRates = [
            ['min_income' => 0, 'max_income' => 500000, 'rate' => 5, 'filing_type' => 'business'],
            ['min_income' => 500001, 'max_income' => 2000000, 'rate' => 10, 'filing_type' => 'business'],
            ['min_income' => 2000001, 'max_income' => 3500000, 'rate' => 15, 'filing_type' => 'business'],
            ['min_income' => 3500001, 'max_income' => 5000000, 'rate' => 20, 'filing_type' => 'business'],
            ['min_income' => 5000001, 'max_income' => null, 'rate' => 25, 'filing_type' => 'business'],
        ];

        // Tax rates for freelancers (FY 2023-2024)
        $freelancerRates = [
            ['min_income' => 0, 'max_income' => 300000, 'rate' => 0, 'filing_type' => 'freelancer'],
            ['min_income' => 300001, 'max_income' => 1000000, 'rate' => 10, 'filing_type' => 'freelancer'],
            ['min_income' => 1000001, 'max_income' => 3000000, 'rate' => 15, 'filing_type' => 'freelancer'],
            ['min_income' => 3000001, 'max_income' => null, 'rate' => 20, 'filing_type' => 'freelancer'],
        ];

        $allRates = array_merge($individualRates, $businessRates, $freelancerRates);
        
        foreach ($allRates as $rate) {
            TaxRate::updateOrCreate(
                [
                    'filing_type' => $rate['filing_type'],
                    'min_income' => $rate['min_income'],
                    'max_income' => $rate['max_income']
                ],
                $rate
            );
        }

        $this->command->info('Tax data seeded successfully!');
    }
}
