<?php

namespace Database\Seeders;

use App\Models\MembershipTier;
use Illuminate\Database\Seeder;

class MembershipTierSeeder extends Seeder
{
    public function run(): void
    {
        $tiers = [
            [
                'name' => 'Bronze',
                'slug' => 'bronze',
                'min_points' => 0,
                'discount_percent' => 0,
                'cashback_percent' => 1,
                'badge_color' => '#CD7F32',
                'benefits' => json_encode(['Akumulasi poin setiap pembelian', '1% cashback poin']),
            ],
            [
                'name' => 'Silver',
                'slug' => 'silver',
                'min_points' => 500,
                'discount_percent' => 5,
                'cashback_percent' => 2,
                'badge_color' => '#A8A9AD',
                'benefits' => json_encode(['5% diskon setiap pesanan', '2% cashback poin', 'Akses promo eksklusif']),
            ],
            [
                'name' => 'Gold',
                'slug' => 'gold',
                'min_points' => 2000,
                'discount_percent' => 10,
                'cashback_percent' => 3,
                'badge_color' => '#FFD700',
                'benefits' => json_encode(['10% diskon setiap pesanan', '3% cashback poin', 'Birthday treat gratis', 'Priority booking']),
            ],
            [
                'name' => 'Platinum',
                'slug' => 'platinum',
                'min_points' => 5000,
                'discount_percent' => 15,
                'cashback_percent' => 5,
                'badge_color' => '#E5E4E2',
                'benefits' => json_encode(['15% diskon setiap pesanan', '5% cashback poin', 'Free delivery', 'Private event akses', 'Dedicated customer service']),
            ],
        ];

        foreach ($tiers as $tier) {
            MembershipTier::updateOrCreate(['slug' => $tier['slug']], $tier);
        }

        $this->command->info('✅ Membership tiers seeded successfully.');
    }
}
