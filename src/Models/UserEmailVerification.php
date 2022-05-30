<?php

namespace SMSkin\IdentityService\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SMSkin\IdentityService\Traits\ClassFromConfig;
use function now;

class UserEmailVerification extends Model
{
    use ClassFromConfig;

    protected $table = 'user_email_verifications';

    protected $fillable = [
        'user_id',
        'credential_id',
        'email',
        'code',
        'is_canceled'
    ];

    protected $hidden = [
        'code'
    ];

    public $casts = [
        'is_canceled' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo($this->getUserModelClass(), 'user_id', 'id');
    }

    public function credential(): BelongsTo
    {
        return $this->belongsTo(UserEmailCredential::class, 'credential_id', 'id');
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
