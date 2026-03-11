<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->date('pickup_date');
            $table->time('pickup_time')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);
            $table->enum('status', [
                'pending',
                'waiting_payment',
                'payment_uploaded',
                'confirmed',
                'processing',
                'ready',
                'completed',
                'cancelled'
            ])->default('pending');
            $table->string('payment_proof')->nullable();
            $table->string('payment_method')->default('transfer');
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
