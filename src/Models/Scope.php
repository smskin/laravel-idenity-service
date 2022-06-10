<?php

namespace SMSkin\IdentityService\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class Scope extends Model
{
    use HasFactory;
    use ClassFromConfig;

    protected $table = 'scopes';

    protected $fillable = [
        'group_id',
        'name',
        'slug'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(self::getUserModelClass(), 'pivot_scope_user', 'scope_id', 'user_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(ScopeGroup::class, 'group_id', 'id');
    }
}
