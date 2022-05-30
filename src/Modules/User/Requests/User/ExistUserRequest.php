<?php

namespace SMSkin\IdentityService\Modules\User\Requests\User;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Core\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class ExistUserRequest extends BaseRequest
{
    use ClassFromConfig;

    /**
     * @var User
     */
    public Model $user;

    public function rules(): array
    {
        return [
            'user' => [
                'required',
                new ExistsEloquentModelRule($this->getUserModelClass())
            ]
        ];
    }

    /**
     * @param User $user
     * @return ExistUserRequest
     */
    public function setUser(Model $user): ExistUserRequest
    {
        $this->user = $user;
        return $this;
    }
}
