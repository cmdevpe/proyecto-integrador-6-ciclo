<?php

namespace App\Models;

use App\Models\SocialAccount;
use App\Models\OneTimePassword;
use App\Contracts\MustVerifyAccount;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class User extends Authenticatable implements MustVerifyEmail
class User extends AuthenticatableUser implements MustVerifyAccount
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Un usuario puede tener múltiples códigos OTP asociados.
     */
    public function oneTimePasswords(): HasMany
    {
        return $this->hasMany(OneTimePassword::class);
    }

    /**
     * Un usuario puede tener múltiples cuentas sociales vinculadas.
     */
    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * Obtiene la URL de la foto de perfil del usuario.
     */
    public function profilePhotoUrl(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if ($this->profile_photo_path) {
                    return Storage::url($this->profile_photo_path);
                }

                $socialAvatar = $this->socialAccounts()->whereNotNull('avatar_url')->value('avatar_url');

                if ($socialAvatar) {
                    return $socialAvatar;
                }

                return $this->defaultProfilePhotoUrl();
            },
        )->shouldCache();
    }

    /**
     * Genera una URL para una foto de perfil por defecto.
     */
    protected function defaultProfilePhotoUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }
}
