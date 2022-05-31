<?php

namespace SMSkin\IdentityService\Modules\Scope\Requests;

use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;

class CreateScopeRequest extends BaseRequest
{
    public ScopeGroup $group;
    public string $name;
    public string $slug;

    public function rules(): array
    {
        return [
            'group' => [
                'required',
                new ExistsEloquentModelRule(ScopeGroup::class)
            ],
            'name' => [
                'required'
            ],
            'slug' => [
                'required',
                'unique:scopes,slug'
            ]
        ];
    }

    /**
     * @param string $name
     * @return CreateScopeRequest
     */
    public function setName(string $name): CreateScopeRequest
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $slug
     * @return CreateScopeRequest
     */
    public function setSlug(string $slug): CreateScopeRequest
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param ScopeGroup $group
     * @return CreateScopeRequest
     */
    public function setGroup(ScopeGroup $group): CreateScopeRequest
    {
        $this->group = $group;
        return $this;
    }
}