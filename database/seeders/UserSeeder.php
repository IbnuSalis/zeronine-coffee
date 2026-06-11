<?php

namespace Database\Seeders;

use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $bronze = MembershipTier::where('slug', 'bronze')->first();
        $gold = MembershipTier::where('slug', 'gold')->first();

        // Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@zeronine.coffee'],
            [
                'name' => 'Admin Zero Nine',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'phone' => '081234567890',
                'membership_tier_id' => $bronze?->id,
            ]
        );
        $admin->syncRoles(['admin']);

        // Cashier
        $cashier = User::updateOrCreate(
            ['email' => 'kasir@zeronine.coffee'],
            [
                'name' => 'Kasir Sari',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'phone' => '081234567892',
                'membership_tier_id' => $bronze?->id,
            ]
        );
        $cashier->syncRoles(['cashier']);

        // Demo Customer
        $customer = User::updateOrCreate(
            ['email' => 'customer@demo.com'],
            [
                'name' => 'Pelanggan Demo',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'phone' => '08123456789',
                'loyalty_points' => 2500,
                'membership_tier_id' => $gold?->id,
            ]
        );
        $customer->syncRoles(['customer']);

        $this->command->info('✅ Users seeded successfully.');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['admin', 'admin@zeronine.coffee', 'password'],
                ['cashier', 'kasir@zeronine.coffee', 'password'],
                ['customer', 'customer@demo.com', 'password'],
            ]
        );
    }
}
