<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MembershipTierSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            TableSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('🎉 Zero Nine Coffee Shop seeded successfully!');
        $this->command->info('');
    }
}
