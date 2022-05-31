<?php

namespace SMSkin\IdentityService\Modules\Scope\Requests;

use SMSkin\IdentityService\Models\Scope;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;

class UpdateScopeNameRequest extends BaseRequest
{
    public Scope $scope;
    public string $name;

    public function rules(): array
    {
        return [
            'scope' => [
                'required',
                new ExistsEloquentModelRule(Scope::class)
            ],
            'name' => [
                'required'
            ]
        ];
    }

    /**
     * @param Scope $scope
     * @return UpdateScopeNameRequest
     */
    public function setScope(Scope $scope): UpdateScopeNameRequest
    {
        $this->scope = $scope;
        return $this;
    }

    /**
     * @param string $name
     * @return UpdateScopeNameRequest
     */
    public function setName(string $name): UpdateScopeNameRequest
    {
        $this->name = $name;
        return $this;
    }
}