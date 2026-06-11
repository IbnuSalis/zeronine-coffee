<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            // Indoor
            ['number' => 'A1', 'name' => 'Corner Cozy', 'capacity' => 2, 'location' => 'Indoor'],
            ['number' => 'A2', 'name' => 'Window Seat', 'capacity' => 2, 'location' => 'Indoor'],
            ['number' => 'A3', 'name' => 'Bookshelf Nook', 'capacity' => 4, 'location' => 'Indoor'],
            ['number' => 'B1', 'name' => 'Long Table 1', 'capacity' => 6, 'location' => 'Indoor'],
            ['number' => 'B2', 'name' => 'Long Table 2', 'capacity' => 6, 'location' => 'Indoor'],
            ['number' => 'C1', 'name' => 'Sofa Booth 1', 'capacity' => 4, 'location' => 'Indoor'],
            ['number' => 'C2', 'name' => 'Sofa Booth 2', 'capacity' => 4, 'location' => 'Indoor'],
            // Outdoor
            ['number' => 'D1', 'name' => 'Garden View', 'capacity' => 2, 'location' => 'Outdoor'],
            ['number' => 'D2', 'name' => 'Street Side', 'capacity' => 4, 'location' => 'Outdoor'],
            // VIP
            ['number' => 'VIP1', 'name' => 'Private Room', 'capacity' => 8, 'location' => 'VIP Room'],
            ['number' => 'VIP2', 'name' => 'Executive Suite', 'capacity' => 12, 'location' => 'VIP Room'],
        ];

        foreach ($tables as $tableData) {
            $table = Table::updateOrCreate(
                ['number' => $tableData['number']],
                array_merge($tableData, ['status' => 'available', 'is_active' => true])
            );
        }

        $this->command->info('✅ Tables seeded successfully (11 tables).');
    }
}
