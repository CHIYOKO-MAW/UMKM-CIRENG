<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'avatar',
        'content',
        'rating',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk customer_name
    public function getCustomerNameAttribute(): string
    {
        return $this->name;
    }

    // Accessor untuk avatar_url
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://via.placeholder.com/48x48?text=' . substr($this->name, 0, 1);
    }

    // Accessor untuk customer_role (default value)
    public function getCustomerRoleAttribute(): string
    {
        return $this->attributes['customer_role'] ?? 'Pelanggan Setia';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
