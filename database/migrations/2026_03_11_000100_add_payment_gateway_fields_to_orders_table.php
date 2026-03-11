<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_reference')->nullable()->unique()->after('payment_method');
            $table->enum('payment_status', ['pending', 'paid', 'expired', 'failed'])->default('pending')->after('payment_reference');
            $table->timestamp('payment_expires_at')->nullable()->after('payment_status');
            $table->timestamp('payment_paid_at')->nullable()->after('payment_expires_at');
        });

        DB::table('orders')
            ->whereIn('status', ['payment_uploaded', 'confirmed', 'processing', 'ready', 'completed'])
            ->update([
                'payment_status' => 'paid',
                'payment_paid_at' => now(),
            ]);

        DB::table('orders')
            ->whereIn('status', ['waiting_payment', 'pending'])
            ->orderBy('id')
            ->chunkById(100, function ($orders) {
                foreach ($orders as $order) {
                    $createdAt = $order->created_at ? Carbon::parse($order->created_at) : now();
                    DB::table('orders')
                        ->where('id', $order->id)
                        ->update([
                            'payment_status' => 'pending',
                            'payment_expires_at' => $createdAt->copy()->addMinutes(30),
                        ]);
                }
            });

        DB::table('orders')
            ->whereNull('payment_reference')
            ->orderBy('id')
            ->chunkById(100, function ($orders) {
                foreach ($orders as $order) {
                    DB::table('orders')
                        ->where('id', $order->id)
                        ->update([
                            'payment_reference' => 'PAY-' . now()->format('Ymd-His') . '-' . $order->id,
                        ]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique('orders_payment_reference_unique');
            $table->dropColumn([
                'payment_reference',
                'payment_status',
                'payment_expires_at',
                'payment_paid_at',
            ]);
        });
    }
};
