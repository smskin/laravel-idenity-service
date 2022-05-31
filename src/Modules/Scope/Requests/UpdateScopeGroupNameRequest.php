<?php

namespace SMSkin\IdentityService\Modules\Scope\Requests;

use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;

class UpdateScopeGroupNameRequest extends BaseRequest
{
    public ScopeGroup $group;
    public string $name;

    public function rules(): array
    {
        return [
            'group' => [
                'required',
                new ExistsEloquentModelRule(ScopeGroup::class)
            ],
            'name' => [
                'required'
            ]
        ];
    }

    /**
     * @param ScopeGroup $group
     * @return UpdateScopeGroupNameRequest
     */
    public function setGroup(ScopeGroup $group): UpdateScopeGroupNameRequest
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @param string $name
     * @return UpdateScopeGroupNameRequest
     */
    public function setName(string $name): UpdateScopeGroupNameRequest
    {
        $this->name = $name;
        return $this;
    }
}