<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Budi Santoso',
                'content' => 'Paling enak cireng rujak se-Indonesia! Bahan-bahannya premium, lezat, dan pasti pesan lagi dan merekomendasikan ke teman-teman.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Siti Nur Azizah',
                'content' => 'Cocok banget untuk acara keluarga. Pre-order-nya gampang, pengiriman cepat, dan anak-anak suka banget sama rasanya!',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Rizki',
                'content' => 'Jadi makanan favorit saya untuk ngemil. Kualitasnya konsisten dan selalu segar. Harga juga terjangkau dengan kualitas premium!',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Dina Pratama',
                'content' => 'Sering saya jadikan konten di Instagram karena visualnya menarik dan rasa-rasanya autentik. Followers saya juga banyak yang jadi pelanggan!',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Rendra Wijaya',
                'content' => 'Harga terjangkau dan porsinya pas, cocok buat diet dan snacking. Kualitas terbaik yang pernah saya temukan!',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Maya Kusuma',
                'content' => 'Paket katering mereka sangat profesional dan hasil yang luar biasa. Tamu-tamu acara saya sangat puas, pasti bakal pakai lagi!',
                'rating' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
