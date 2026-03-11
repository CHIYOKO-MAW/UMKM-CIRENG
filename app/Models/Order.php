<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_EXPIRED = 'expired';
    const PAYMENT_STATUS_FAILED = 'failed';

    protected $fillable = [
        'user_id',
        'order_number',
        'pickup_date',
        'pickup_time',
        'delivery_address',
        'subtotal',
        'total_price',
        'status',
        'payment_proof',
        'payment_method',
        'payment_reference',
        'payment_status',
        'payment_expires_at',
        'payment_paid_at',
        'notes',
        'admin_notes',
        'confirmed_at',
        'completed_at',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'subtotal' => 'decimal:2',
        'total_price' => 'decimal:2',
        'payment_expires_at' => 'datetime',
        'payment_paid_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    const STATUS_LABELS = [
        'pending' => 'Menunggu Konfirmasi',
        'waiting_payment' => 'Menunggu Pembayaran',
        'payment_uploaded' => 'Menunggu Verifikasi Admin',
        'confirmed' => 'Dikonfirmasi',
        'processing' => 'Sedang Diproses',
        'ready' => 'Siap Dikirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    const STATUS_COLORS = [
        'pending' => 'yellow',
        'waiting_payment' => 'orange',
        'payment_uploaded' => 'blue',
        'confirmed' => 'green',
        'processing' => 'purple',
        'ready' => 'teal',
        'completed' => 'gray',
        'cancelled' => 'red',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'CR';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return $prefix . $date . $random;
    }

    public static function generatePaymentReference(): string
    {
        return 'PAY-' . now()->format('Ymd-His') . '-' . strtoupper(substr(uniqid(), -4));
    }

    public function isPaymentExpired(): bool
    {
        return $this->payment_status !== self::PAYMENT_STATUS_PAID
            && $this->payment_expires_at
            && now()->greaterThan($this->payment_expires_at);
    }

    public function scopePaidForAdmin(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('payment_status', self::PAYMENT_STATUS_PAID)
                ->orWhere(function (Builder $legacy) {
                    $legacy->whereNull('payment_status')
                        ->whereIn('status', ['payment_uploaded', 'confirmed', 'processing', 'ready', 'completed', 'cancelled']);
                });
        });
    }
}
