<?php

use App\Models\Order;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('orders:expire-unpaid', function () {
    $expiredOrders = Order::where('status', 'waiting_payment')
        ->where('payment_status', Order::PAYMENT_STATUS_PENDING)
        ->whereNotNull('payment_expires_at')
        ->where('payment_expires_at', '<', now())
        ->get();

    $count = 0;

    foreach ($expiredOrders as $order) {
        $order->update([
            'status' => 'cancelled',
            'payment_status' => Order::PAYMENT_STATUS_EXPIRED,
            'admin_notes' => 'Pembayaran melewati batas waktu.',
        ]);
        $count++;
    }

    $this->info("Expired orders updated: {$count}");
})->purpose('Automatically expire unpaid orders after payment timeout');

Schedule::command('orders:expire-unpaid')->everyMinute();
