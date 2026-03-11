<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_order_with_zero_quantity_items(): void
    {
        $user = User::factory()->create();

        $productA = Product::create([
            'name' => 'Cireng Original',
            'description' => 'Test',
            'short_description' => 'Test',
            'price' => 10000,
            'category' => 'cireng',
            'min_order' => 1,
            'unit' => 'pcs',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 1,
        ]);

        $productB = Product::create([
            'name' => 'Cireng Pedas',
            'description' => 'Test',
            'short_description' => 'Test',
            'price' => 12000,
            'category' => 'cireng',
            'min_order' => 1,
            'unit' => 'pcs',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 2,
        ]);

        $response = $this->actingAs($user)->post(route('order.store'), [
            'pickup_date' => now()->addDay()->toDateString(),
            'pickup_time' => '10:00-12:00',
            'delivery_address' => 'Jl. Mawar No. 10, Bandung',
            'items' => [
                $productA->id => ['product_id' => $productA->id, 'quantity' => 2],
                $productB->id => ['product_id' => $productB->id, 'quantity' => 0],
            ],
        ]);

        $response->assertRedirect();

        $order = Order::first();
        $this->assertNotNull($order);
        $this->assertSame('waiting_payment', $order->status);
        $this->assertSame(Order::PAYMENT_STATUS_PENDING, $order->payment_status);
        $this->assertSame('10:00:00', $order->pickup_time);
        $this->assertSame('Jl. Mawar No. 10, Bandung', $order->delivery_address);
    }

    public function test_customer_payment_simulation_marks_order_paid(): void
    {
        $customer = User::factory()->create();
        User::factory()->create(['role' => 'admin']);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => Order::generateOrderNumber(),
            'pickup_date' => now()->addDay()->toDateString(),
            'subtotal' => 50000,
            'total_price' => 50000,
            'status' => 'waiting_payment',
            'payment_method' => 'transfer',
            'payment_reference' => Order::generatePaymentReference(),
            'payment_status' => Order::PAYMENT_STATUS_PENDING,
            'payment_expires_at' => now()->addMinutes(30),
        ]);

        $response = $this->actingAs($customer)->post(route('order.upload-payment', $order), [
            'payment_method' => 'bca_va',
        ]);

        $response->assertRedirect(route('dashboard'));

        $order->refresh();
        $this->assertSame('payment_uploaded', $order->status);
        $this->assertSame(Order::PAYMENT_STATUS_PAID, $order->payment_status);
        $this->assertSame('bca_va', $order->payment_method);
        $this->assertNotNull($order->payment_paid_at);
    }

    public function test_admin_orders_page_shows_only_paid_orders_by_default(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create();

        $paidOrder = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'CRPAID001',
            'pickup_date' => now()->addDay()->toDateString(),
            'subtotal' => 10000,
            'total_price' => 10000,
            'status' => 'payment_uploaded',
            'payment_method' => 'bca_va',
            'payment_reference' => 'PAY-PAID-001',
            'payment_status' => Order::PAYMENT_STATUS_PAID,
            'payment_paid_at' => now(),
        ]);

        $unpaidOrder = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'CRWAIT001',
            'pickup_date' => now()->addDay()->toDateString(),
            'subtotal' => 15000,
            'total_price' => 15000,
            'status' => 'waiting_payment',
            'payment_method' => 'transfer',
            'payment_reference' => 'PAY-WAIT-001',
            'payment_status' => Order::PAYMENT_STATUS_PENDING,
            'payment_expires_at' => now()->addMinutes(30),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.orders.index'));

        $response->assertOk();
        $response->assertSee($paidOrder->order_number);
        $response->assertDontSee($unpaidOrder->order_number);
    }
}
