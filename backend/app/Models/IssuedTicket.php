<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IssuedTicket extends Model
{
    protected $fillable = [
        'uid',
        'payment_id',
        'ticket_id',
        'ticket_name',
        'price_paid',
        'currency',
        'holder_name',
        'holder_email',
        'holder_phone',
        'status',
        'email_sent',
        'used_at',
    ];

    protected $casts = [
        'email_sent' => 'boolean',
        'used_at'    => 'datetime',
        'price_paid' => 'integer',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function isValid(): bool
    {
        return $this->status === 'active';
    }
}
