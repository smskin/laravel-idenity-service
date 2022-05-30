<?php

namespace SMSkin\IdentityService\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class ScopeGroup extends Model
{
    use HasFactory;
    use ClassFromConfig;

    protected $table = 'scope_groups';

    protected $fillable = [
        'name',
        'slug'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany($this->getUserModelClass(), 'pivot_scope_group_user', 'group_id', 'user_id');
    }

    public function scopes(): HasMany
    {
        return $this->hasMany(Scope::class, 'group_id', 'id');
    }
}
