<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class MagicLink extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'token',
        'consumed_at',
        'expires_at',

    ];

    protected $casts = [
        'consumed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para obtener solo los enlaces que son válidos (no consumidos y no expirados).
     */
    public function scopeValid(Builder $query): void
    {
        $query->whereNull('consumed_at')->where('expires_at', '>', now());
    }

    /**
     * Scope para obtener los enlaces que ya han sido consumidos.
     */
    public function scopeConsumed(Builder $query): void
    {
        $query->whereNotNull('consumed_at');
    }

    /**
     * Scope para obtener los enlaces que han expirado (y no fueron consumidos).
     */
    public function scopeExpired(Builder $query): void
    {
        $query->whereNull('consumed_at')->where('expires_at', '<=', now());
    }
}
