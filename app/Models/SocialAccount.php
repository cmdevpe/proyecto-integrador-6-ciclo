<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read User $user
 */
class SocialAccount extends Model
{
    protected $fillable = [
        'user_id',
        'provider_name',
        'provider_id',
        'avatar_url',
    ];

    /**
     * Una cuenta social pertenece a un único usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
