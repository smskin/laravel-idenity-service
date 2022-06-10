<?php

namespace SMSkin\IdentityService\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class UserEmailCredential extends Model
{
    use ClassFromConfig;

    protected $table = 'user_email_credentials';

    protected $fillable = [
        'user_id',
        'email',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(self::getUserModelClass(), 'user_id', 'id');
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(UserEmailVerification::class, 'credential_id', 'id');
    }

    public function isVerified(): bool
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return (bool)$this->verified_at;
    }
}
