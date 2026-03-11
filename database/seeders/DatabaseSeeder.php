<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(['email' => 'admin@cireng.test'], [
            'name' => 'Admin Cireng',
            'email' => 'admin@cireng.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '08123456789',
        ]);

        // Test Customer
        User::updateOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '08987654321',
            'address' => 'Jl. Contoh No. 10, Kec. Cibinong, Kab. Bogor',
        ]);

        // Call other seeders
        $this->call([
            ProductSeeder::class,
            TestimonialSeeder::class,
            OrderHistorySeeder::class,
        ]);
    }
}
