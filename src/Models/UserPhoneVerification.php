<?php

namespace SMSkin\IdentityService\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function now;

class UserPhoneVerification extends Model
{
    protected $table = 'user_phone_verifications';

    protected $fillable = [
        'phone',
        'code',
        'is_canceled'
    ];

    protected $hidden = [
        'code'
    ];

    public $casts = [
        'is_canceled' => 'boolean'
    ];

    public function credential(): BelongsTo
    {
        return $this->belongsTo(UserPhoneCredential::class, 'phone', 'phone');
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder
            ->where('is_canceled', false)
            ->where('created_at', '>', now()->subHour());
    }

    public function scopeInactive(Builder $builder): Builder
    {
        return $builder
            ->where(function (Builder $builder) {
                $builder
                    ->where('is_canceled', true)
                    ->orWhere('created_at', '<=', now()->subHour());
            });
    }
}
