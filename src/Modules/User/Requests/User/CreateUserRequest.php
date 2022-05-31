<?php

namespace SMSkin\IdentityService\Modules\User\Requests\User;

use SMSkin\LaravelSupport\BaseRequest;

class CreateUserRequest extends BaseRequest
{
    public ?string $name = null;

    public function rules(): array
    {
        return [
            'name' => [
                'nullable',
                'string'
            ]
        ];
    }

    /**
     * @param string|null $name
     * @return CreateUserRequest
     */
    public function setName(?string $name): CreateUserRequest
    {
        $this->name = $name;
        return $this;
    }
}
