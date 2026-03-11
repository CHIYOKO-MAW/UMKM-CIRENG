<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'image',
        'category',
        'min_order',
        'unit',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            // Check if the image file exists in storage
            if (file_exists(public_path('storage/' . $this->image))) {
                return asset('storage/' . $this->image);
            }
            // Try to check in storage/app/public
            if (file_exists(storage_path('app/public/' . $this->image))) {
                return asset('storage/' . $this->image);
            }
        }
        // Return a dynamic emoji-based placeholder based on product name
        return 'https://placehold.co/400x300/FF6B35/FFFFFF?text=' . urlencode($this->name);
    }

    /**
     * Get emoji based on product category for placeholder
     */
    public function getPlaceholderEmoji(): string
    {
        $categoryEmojis = [
            'cireng' => '🍳',
            'basreng' => '🌶️',
            'rujak' => '🥗',
            'minuman' => '🥤',
            'paket' => '📦',
            'lainnya' => '🍽️',
        ];

        return $categoryEmojis[$this->category] ?? '🍴';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
