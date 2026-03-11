<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class OrderHistorySeeder extends Seeder
{
    public function run(): void
    {
        $targetCount = 220;
        $currentCount = Order::count();

        $products = Product::query()
            ->where('is_active', true)
            ->where('price', '>', 0)
            ->get();

        if ($products->isEmpty()) {
            return;
        }

        $this->ensureCustomers();
        $customers = User::query()->where('role', 'customer')->get();
        if ($customers->isEmpty()) {
            return;
        }

        $this->normalizeSerangAddresses();

        if ($currentCount >= $targetCount) {
            return;
        }

        $needed = $targetCount - $currentCount;

        for ($i = 0; $i < $needed; $i++) {
            $customer = $customers->random();
            $createdAt = Carbon::now()->subDays(random_int(1, 180))->subMinutes(random_int(0, 1439));
            $status = $this->randomStatus();
            $itemPayload = $this->buildItems($products);
            $subtotal = $itemPayload['subtotal'];
            $items = $itemPayload['items'];
            $paidAt = (clone $createdAt)->addMinutes(random_int(10, 180));
            $completedAt = $status === 'completed'
                ? (clone $createdAt)->addDays(random_int(1, 5))->addMinutes(random_int(30, 600))
                : null;

            $order = Order::create([
                'user_id' => $customer->id,
                'order_number' => 'CRHIS' . $createdAt->format('Ymd') . strtoupper(substr(uniqid(), -6)),
                'pickup_date' => (clone $createdAt)->addDays(random_int(1, 3))->toDateString(),
                'pickup_time' => sprintf('%02d:00:00', random_int(8, 16)),
                'delivery_address' => $customer->address ?: $this->randomAddress(),
                'subtotal' => $subtotal,
                'total_price' => $subtotal,
                'status' => $status,
                'payment_method' => $this->randomPaymentMethod(),
                'payment_reference' => 'PAY-HIS-' . $createdAt->format('YmdHis') . '-' . strtoupper(substr(uniqid(), -4)),
                'payment_status' => Order::PAYMENT_STATUS_PAID,
                'payment_paid_at' => $paidAt,
                'payment_expires_at' => (clone $createdAt)->addMinutes(30),
                'notes' => fake()->boolean(40) ? fake()->sentence(6) : null,
                'admin_notes' => fake()->boolean(35) ? fake()->sentence(8) : null,
                'confirmed_at' => in_array($status, ['confirmed', 'processing', 'ready', 'completed'], true)
                    ? (clone $createdAt)->addHours(random_int(1, 12))
                    : null,
                'completed_at' => $completedAt,
                'created_at' => $createdAt,
                'updated_at' => $completedAt ?? (clone $createdAt)->addDays(random_int(0, 4)),
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }

    private function ensureCustomers(): void
    {
        $existing = User::query()->where('role', 'customer')->count();
        if ($existing >= 30) {
            return;
        }

        $toCreate = 30 - $existing;
        User::factory()->count($toCreate)->create()->each(function (User $user): void {
            $user->update([
                'role' => 'customer',
                'phone' => '08' . random_int(111111111, 999999999),
                'address' => $this->randomAddress(),
            ]);
        });
    }

    private function buildItems(Collection $products): array
    {
        $selected = $products->random(random_int(1, min(4, $products->count())));
        if ($selected instanceof Collection === false) {
            $selected = collect([$selected]);
        }

        $items = [];
        $subtotal = 0;

        foreach ($selected as $product) {
            $qty = random_int(1, 5);
            $lineSubtotal = (float) $product->price * $qty;
            $subtotal += $lineSubtotal;

            $items[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => $qty,
                'subtotal' => $lineSubtotal,
            ];
        }

        return [
            'items' => $items,
            'subtotal' => $subtotal,
        ];
    }

    private function randomStatus(): string
    {
        $roll = random_int(1, 100);
        if ($roll <= 68) {
            return 'completed';
        }
        if ($roll <= 78) {
            return 'cancelled';
        }
        if ($roll <= 86) {
            return 'payment_uploaded';
        }
        if ($roll <= 92) {
            return 'confirmed';
        }
        if ($roll <= 97) {
            return 'processing';
        }
        return 'ready';
    }

    private function randomPaymentMethod(): string
    {
        $methods = ['bca_va', 'bri_va', 'bni_va', 'mandiri_va', 'gopay', 'ovo', 'dana', 'qris'];
        return $methods[array_rand($methods)];
    }

    private function randomAddress(): string
    {
        $streets = ['Jl. Ahmad Yani', 'Jl. Raya Serang', 'Jl. Ki Mas Jong', 'Jl. Trip Jamaksari', 'Jl. Veteran'];
        $areas = [
            'Kec. Serang, Kota Serang',
            'Kec. Cipocok Jaya, Kota Serang',
            'Kec. Taktakan, Kota Serang',
            'Kec. Kasemen, Kota Serang',
            'Kec. Curug, Kota Serang',
            'Kec. Kramatwatu, Kab. Serang',
            'Kec. Ciruas, Kab. Serang',
            'Kec. Cikande, Kab. Serang',
            'Kec. Pontang, Kab. Serang',
            'Kec. Walantaka, Kota Serang',
        ];
        return $streets[array_rand($streets)] . ' No. ' . random_int(1, 120) . ', ' .
            'RT ' . random_int(1, 9) . '/RW ' . random_int(1, 12) . ', ' .
            $areas[array_rand($areas)] . ', Banten';
    }

    private function normalizeSerangAddresses(): void
    {
        User::query()
            ->where('role', 'customer')
            ->where(function ($query) {
                $query->whereNull('address')
                    ->orWhere('address', 'not like', '%Serang%');
            })
            ->chunkById(100, function ($users): void {
                foreach ($users as $user) {
                    $user->update(['address' => $this->randomAddress()]);
                }
            });

        Order::query()
            ->where(function ($query) {
                $query->whereNull('delivery_address')
                    ->orWhere('delivery_address', 'not like', '%Serang%');
            })
            ->chunkById(100, function ($orders): void {
                foreach ($orders as $order) {
                    $order->update(['delivery_address' => $this->randomAddress()]);
                }
            });
    }
}
