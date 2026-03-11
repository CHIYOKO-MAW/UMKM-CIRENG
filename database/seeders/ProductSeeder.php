<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Cireng Rujak Original',
                'slug' => Str::slug('Cireng Rujak Original'),
                'description' => 'Cireng rujak klasik dengan bumbu rujak tradisional yang gurih dan pedas. Dibuat dengan bahan-bahan pilihan premium.',
                'short_description' => 'Rasa tradisional yang autentik',
                'price' => 35000,
                'category' => 'original',
                'min_order' => 1,
                'unit' => 'pcs',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Cireng Rujak Pedas',
                'slug' => Str::slug('Cireng Rujak Pedas'),
                'description' => 'Untuk pecinta pedas! Dengan campuran sambal khusus yang membakar. Sensasi pedas yang tak terlupakan.',
                'short_description' => 'Untuk pecinta sensasi pedas',
                'price' => 40000,
                'category' => 'spicy',
                'min_order' => 1,
                'unit' => 'pcs',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Cireng Rujak Mild',
                'slug' => Str::slug('Cireng Rujak Mild'),
                'description' => 'Cireng rujak dengan rasa yang lebih ringan, cocok untuk keluarga dan anak-anak. Lezat tanpa terlalu pedas.',
                'short_description' => 'Rasa ringan untuk keluarga',
                'price' => 32000,
                'category' => 'mild',
                'min_order' => 1,
                'unit' => 'pcs',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Cireng Rujak Spesial',
                'slug' => Str::slug('Cireng Rujak Spesial'),
                'description' => 'Edisi terbatas dengan kacang dan bahan premium pilihan. Rasa yang lebih kaya dan kompleks.',
                'short_description' => 'Edisi premium dengan kacang',
                'price' => 50000,
                'category' => 'premium',
                'min_order' => 1,
                'unit' => 'pcs',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Paket Combo Keluarga',
                'slug' => Str::slug('Paket Combo Keluarga'),
                'description' => 'Paket hemat untuk keluarga dengan 4 porsi berbeda. Hemat dan lebih menguntungkan.',
                'short_description' => 'Paket hemat 4 porsi',
                'price' => 120000,
                'category' => 'package',
                'min_order' => 1,
                'unit' => 'paket',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Paket Katering',
                'slug' => Str::slug('Paket Katering'),
                'description' => 'Pesan dalam jumlah besar untuk acara spesial Anda. Hubungi kami untuk harga dan detail lebih lanjut.',
                'short_description' => 'Untuk acara dan gathering',
                'price' => 0,
                'category' => 'catering',
                'min_order' => 10,
                'unit' => 'box',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
