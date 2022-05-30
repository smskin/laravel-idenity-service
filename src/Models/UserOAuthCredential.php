<?php

namespace SMSkin\IdentityService\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SMSkin\IdentityService\Modules\OAuth\Enums\DriverEnum;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class UserOAuthCredential extends Model
{
    use ClassFromConfig;

    protected $table = 'user_oauth_credentials';

    protected $casts = [
        'driver' => DriverEnum::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo($this->getUserModelClass(), 'user_id', 'id');
    }
}
