<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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
        'early_bird_price',
        'early_bird_starts_at',
        'early_bird_ends_at',
    ];

    protected $casts = [
        'includes'             => 'array',
        'is_active'            => 'boolean',
        'price'                => 'integer',
        'early_bird_price'     => 'integer',
        'stock'                => 'integer',
        'sold'                 => 'integer',
        'early_bird_starts_at' => 'datetime',
        'early_bird_ends_at'   => 'datetime',
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

    /**
     * Vrai si le ticket est actuellement en période early bird.
     */
    public function isEarlyBird(): bool
    {
        if (!$this->early_bird_price || !$this->early_bird_starts_at || !$this->early_bird_ends_at) {
            return false;
        }

        $now = Carbon::now();
        return $now->between($this->early_bird_starts_at, $this->early_bird_ends_at);
    }

    /**
     * Prix effectif : early bird si actif, sinon prix normal.
     */
    public function getEffectivePriceAttribute(): int
    {
        return $this->isEarlyBird() ? $this->early_bird_price : $this->price;
    }
}
