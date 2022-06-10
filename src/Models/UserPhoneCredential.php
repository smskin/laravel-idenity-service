<?php

namespace SMSkin\IdentityService\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class UserPhoneCredential extends Model
{
    use ClassFromConfig;

    protected $table = 'user_phone_credentials';

    protected $fillable = [
        'user_id',
        'phone',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(self::getUserModelClass(), 'user_id', 'id');
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(UserPhoneVerification::class, 'phone', 'phone');
    }
}
