<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Signature Coffee', 'slug' => 'signature-coffee', 'sort_order' => 1],
            ['name' => 'Manual Brew', 'slug' => 'manual-brew', 'sort_order' => 2],
            ['name' => 'Cold Brew', 'slug' => 'cold-brew', 'sort_order' => 3],
            ['name' => 'Non-Coffee', 'slug' => 'non-coffee', 'sort_order' => 4],
            ['name' => 'Food', 'slug' => 'food', 'sort_order' => 5],
            ['name' => 'Pastry', 'slug' => 'pastry', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $menuImages = [
            'zero-nine-signature-blend' => 'menus/AymGlfV4NGvF2lEnLaBjG8rnl3lEjyidBZ2X5ym9.jpg',
            'caramel-cloud-latte' => 'menus/OVjO9NM7nxWptUPuVCkVq7z3IY4ZVOPJ8DCT3ks0.jpg',
            'dark-matter-espresso' => 'menus/zokToi0RduCCPB9c9o3SsAyQfXOFurr2JNEAHmlz.jpg',
            'hazelnut-dirty-matcha' => 'menus/IFMM2NGUQJ6Ygfvyi21jaJytcHZ06BchMw3lVWFl.jpg',
            'v60-pour-over-gayo' => 'menus/7Xg2sfJGXwCRUd12nj3e2vcZTLkMAyNhUDNiXCU2.jpg',
            'aeropress-toraja' => 'menus/RgBXgjzc8RVeATq3vEk89aM7af1U1pMmEXRga5Yu.jpg',
            'signature-cold-brew' => 'menus/MJEF9dNNSu1bnIzvl0t9BLMWxowJsIelJTcJf6y6.jpg',
            'nitro-cold-brew' => 'menus/JOFvEKgPQMbzpdyBC4AfEqGGlQyQaw2ixPnS6JOA.jpg',
            'matcha-latte-premium' => 'menus/6CjQfdBtUaWbubfLuhsGvy64jSjVOhQolL3J6tXq.jpg',
            'brown-sugar-milk-tea' => 'menus/Pu42gwfvJ4waWZJoJYyxFhYQoA3BkS14wt496aoj.jpg',
            'avocado-toast-zero-nine' => 'menus/iPdfXgmTd48C5VMcHKOW4gUVb5HJd4ptnS7Cfq6e.jpg',
            'signature-eggs-benedict' => 'menus/2Gu1V9lrIPzeKM2n9ky8C7T7iIrmxLwLcVMk4PME.jpg',
            'croissant-au-beurre' => 'menus/IcgS18ZCzsCEdegx8kJdEA0Ll4DsGgYeh72NwSoZ.webp',
            'coffee-tiramisu-cake' => 'menus/5gM1u1vM3bFRmbnTk2X4Blk0okyYduhp7flqgwMp.jpg',
        ];

        $menus = [
            // Signature Coffee
            [
                'category' => 'signature-coffee', 'name' => 'Zero Nine Signature Blend', 'slug' => 'zero-nine-signature-blend',
                'description' => 'Perpaduan sempurna antara biji kopi Arabika Gayo dan Toraja, menghadirkan cita rasa cokelat hitam dengan aftertaste karamel yang memanjakan.',
                'price' => 45000, 'stock' => 50, 'is_featured' => true, 'is_best_seller' => true, 'preparation_time' => 5, 'calories' => 120,
            ],
            [
                'category' => 'signature-coffee', 'name' => 'Caramel Cloud Latte', 'slug' => 'caramel-cloud-latte',
                'description' => 'Latte premium dengan cloud foam dari steamed milk, drizzle karamel artisan, dan taburan gold flakes.',
                'price' => 52000, 'stock' => 40, 'is_featured' => true, 'preparation_time' => 7, 'calories' => 280,
            ],
            [
                'category' => 'signature-coffee', 'name' => 'Dark Matter Espresso', 'slug' => 'dark-matter-espresso',
                'description' => 'Double shot espresso pekat dengan crema tebal. Untuk jiwa-jiwa pemberani yang mencintai kopi dalam bentuk paling murninya.',
                'price' => 35000, 'stock' => 60, 'is_new' => true, 'preparation_time' => 3, 'calories' => 15,
            ],
            [
                'category' => 'signature-coffee', 'name' => 'Hazelnut Dirty Matcha', 'slug' => 'hazelnut-dirty-matcha',
                'description' => 'Espresso shot yang "jatuh" ke dalam matcha latte dengan sirup hazelnut. Perpaduan East meets West yang menawan.',
                'price' => 58000, 'stock' => 35, 'is_featured' => true, 'preparation_time' => 8, 'calories' => 240,
            ],
            // Manual Brew
            [
                'category' => 'manual-brew', 'name' => 'V60 Pour Over Gayo', 'slug' => 'v60-pour-over-gayo',
                'description' => 'Single origin Arabika Gayo Aceh, diseduh dengan teknik V60 pour over. Menonjolkan keasaman citrus yang segar dan aroma floral.',
                'price' => 55000, 'stock' => 20, 'is_featured' => true, 'preparation_time' => 10, 'calories' => 5,
            ],
            [
                'category' => 'manual-brew', 'name' => 'Aeropress Toraja', 'slug' => 'aeropress-toraja',
                'description' => 'Kopi Toraja Sulawesi diseduh Aeropress, menghasilkan body penuh dengan rasa kacang panggang dan dark chocolate.',
                'price' => 50000, 'stock' => 20, 'preparation_time' => 8, 'calories' => 5,
            ],
            // Cold Brew
            [
                'category' => 'cold-brew', 'name' => 'Signature Cold Brew', 'slug' => 'signature-cold-brew',
                'description' => 'Cold brew 18 jam dengan biji kopi pilihan. Halus, smooth, dan rendah asam. Cocok disajikan over ice.',
                'price' => 48000, 'stock' => 30, 'is_best_seller' => true, 'preparation_time' => 2, 'calories' => 10,
            ],
            [
                'category' => 'cold-brew', 'name' => 'Nitro Cold Brew', 'slug' => 'nitro-cold-brew',
                'description' => 'Cold brew yang diinjeksikan nitrogen, menghasilkan tekstur creamy seperti stout beer tanpa alkohol.',
                'price' => 62000, 'stock' => 15, 'is_new' => true, 'preparation_time' => 2, 'calories' => 5,
            ],
            // Non Coffee
            [
                'category' => 'non-coffee', 'name' => 'Matcha Latte Premium', 'slug' => 'matcha-latte-premium',
                'description' => 'Matcha ceremonial grade dari Uji Kyoto, dicampur dengan steamed oat milk. Earthly, creamy, dan menenangkan.',
                'price' => 52000, 'stock' => 40, 'is_best_seller' => true, 'preparation_time' => 6, 'calories' => 180,
            ],
            [
                'category' => 'non-coffee', 'name' => 'Brown Sugar Milk Tea', 'slug' => 'brown-sugar-milk-tea',
                'description' => 'Teh hitam premium dengan gula aren Jawa, steamed milk, dan tiger stripes karamel yang memukau.',
                'price' => 45000, 'stock' => 50, 'preparation_time' => 5, 'calories' => 320,
            ],
            // Food
            [
                'category' => 'food', 'name' => 'Avocado Toast Zero Nine', 'slug' => 'avocado-toast-zero-nine',
                'description' => 'Sourdough artisan panggang dengan smashed avocado, telur poached, pomodoro cherry, dan olive oil.',
                'price' => 75000, 'stock' => 15, 'is_best_seller' => true, 'preparation_time' => 12, 'calories' => 420,
            ],
            [
                'category' => 'food', 'name' => 'Signature Eggs Benedict', 'slug' => 'signature-eggs-benedict',
                'description' => 'Muffin Inggris dengan Canadian bacon, telur poached, dan saus hollandaise rumahan yang kaya.',
                'price' => 88000, 'stock' => 10, 'is_featured' => true, 'preparation_time' => 15, 'calories' => 580,
            ],
            // Pastry
            [
                'category' => 'pastry', 'name' => 'Croissant au Beurre', 'slug' => 'croissant-au-beurre',
                'description' => 'Croissant dengan lapisan 27 lapis butter premium, renyah di luar, lembut di dalam. Dipanggang segar setiap pagi.',
                'price' => 38000, 'stock' => 25, 'is_best_seller' => true, 'preparation_time' => 2, 'calories' => 290,
            ],
            [
                'category' => 'pastry', 'name' => 'Coffee Tiramisu Cake', 'slug' => 'coffee-tiramisu-cake',
                'description' => 'Tiramisu klasik Italia dengan espresso shot Zero Nine, mascarpone premium, dan dark cocoa powder.',
                'price' => 65000, 'stock' => 12, 'is_featured' => true, 'preparation_time' => 3, 'calories' => 380,
            ],
        ];

        foreach ($menus as $menuData) {
            $category = Category::where('slug', $menuData['category'])->first();
            if (! $category) continue;

            $data = collect($menuData)->except('category')->merge([
                'category_id' => $category->id,
                'is_available' => true,
            ])->toArray();

            $existingMenu = Menu::where('slug', $data['slug'])->first();
            if ((! $existingMenu || ! $existingMenu->image) && isset($menuImages[$data['slug']])) {
                $data['image'] = $menuImages[$data['slug']];
            }

            Menu::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $this->command->info('✅ Menu items seeded successfully (' . count($menus) . ' items).');
    }
}
