<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'subtitle',
        'description',
        'category',
        'price',
        'currency',
        'includes',
        'stock',
        'sold',
        'is_active',
        'image_path',
    ];

    protected $casts = [
        'includes'  => 'array',
        'is_active' => 'boolean',
        'price'     => 'integer',
        'stock'     => 'integer',
        'sold'      => 'integer',
    ];

    public function issuedTickets(): HasMany
    {
        return $this->hasMany(IssuedTicket::class);
    }

    public function getAvailableStockAttribute(): int
    {
        return max(0, $this->stock - $this->sold);
    }

    public function isAvailable(): bool
    {
        return $this->is_active && $this->available_stock > 0;
    }
}
