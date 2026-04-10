<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'max_uses',
        'uses_count',
        'starts_at',
        'expires_at',
        'is_active',
        'applicable_slugs',
        'description',
    ];

    protected $casts = [
        'value'            => 'integer',
        'max_uses'         => 'integer',
        'uses_count'       => 'integer',
        'is_active'        => 'boolean',
        'applicable_slugs' => 'array',
        'starts_at'        => 'datetime',
        'expires_at'       => 'datetime',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Vérifie si le code est utilisable (actif, dans les dates, pas épuisé).
     */
    public function isUsable(): bool
    {
        if (!$this->is_active) return false;

        $now = Carbon::now();

        if ($this->starts_at && $now->isBefore($this->starts_at)) return false;
        if ($this->expires_at && $now->isAfter($this->expires_at)) return false;
        if ($this->max_uses !== null && $this->uses_count >= $this->max_uses) return false;

        return true;
    }

    /**
     * Calcule le montant de la réduction pour un prix donné.
     * Ne s'applique PAS aux tickets en early bird.
     */
    public function computeDiscount(int $price): int
    {
        if ($this->type === 'percentage') {
            return (int) round($price * $this->value / 100);
        }

        // fixed : on ne peut pas dépasser le prix du ticket
        return min($this->value, $price);
    }

    /**
     * Vérifie si le code est applicable à un slug de ticket.
     * applicable_slugs null = applicable à tout ticket non early bird.
     */
    public function appliesToSlug(string $slug): bool
    {
        if ($this->applicable_slugs === null) return true;
        return in_array($slug, $this->applicable_slugs, true);
    }
}
