<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = [
        'tx_ref',
        'paydunya_token',
        'status',
        'amount',
        'currency',
        'customer_name',
        'customer_email',
        'customer_phone',
        'cart_items',
        'paydunya_response',
        'paid_at',
        'promo_code_id',
        'discount_amount',
    ];

    protected $casts = [
        'cart_items'      => 'array',
        'paydunya_response' => 'array',
        'paid_at'         => 'datetime',
        'amount'          => 'integer',
        'discount_amount' => 'integer',
    ];

    protected $hidden = [
        'paydunya_response',
    ];

    public function issuedTickets(): HasMany
    {
        return $this->hasMany(IssuedTicket::class);
    }

    public function promoCode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
