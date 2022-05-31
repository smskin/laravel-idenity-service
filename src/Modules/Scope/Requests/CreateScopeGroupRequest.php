<?php

namespace SMSkin\IdentityService\Modules\Scope\Requests;

use SMSkin\LaravelSupport\BaseRequest;

class CreateScopeGroupRequest extends BaseRequest
{
    public string $name;
    public string $slug;

    public function rules(): array
    {
        return [
            'name' => [
                'required'
            ],
            'slug' => [
                'required',
                'unique:scope_groups,slug'
            ]
        ];
    }

    /**
     * @param string $name
     * @return CreateScopeGroupRequest
     */
    public function setName(string $name): CreateScopeGroupRequest
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $slug
     * @return CreateScopeGroupRequest
     */
    public function setSlug(string $slug): CreateScopeGroupRequest
    {
        $this->slug = $slug;
        return $this;
    }
}