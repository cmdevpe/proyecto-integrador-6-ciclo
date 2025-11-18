<?php

namespace App\Models;

use App\Enums\OtpPurpose;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OneTimePassword extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'purpose',
        'user_id',
        'code_hash',
        'channel',
        'attempts',
        'max_attempts',
        'consumed_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'purpose' => OtpPurpose::class,
            'attempts' => 'integer',
            'max_attempts' => 'integer',
            'consumed_at' => 'datetime',
            'created_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Filtra por propósito (enum o string)
    public function scopePurpose(Builder $query, OtpPurpose|string $purpose): Builder
    {
        $value = $purpose instanceof OtpPurpose ? $purpose->value : $purpose;
        return $query->where('purpose', $value);
    }

    // Solo OTP no consumidos
    public function scopeUnconsumed(Builder $query): Builder
    {
        return $query->whereNull('consumed_at');
    }

    // Solo OTP vigentes (no expirados)
    public function scopeNotExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '>', now());
    }

    // OTP activos (no consumidos y no expirados)
    public function scopeActive(Builder $query): Builder
    {
        return $query->unconsumed()->notExpired();
    }

    // Ordena del más reciente al más antiguo por created_at
    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
}
