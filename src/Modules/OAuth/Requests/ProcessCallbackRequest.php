<?php

namespace SMSkin\IdentityService\Modules\OAuth\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class ProcessCallbackRequest extends BaseRequest
{
    use ClassFromConfig;

    /**
     * @var User|null
     */
    public ?Model $user = null;

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                'user' => [
                    'nullable',
                    new ExistsEloquentModelRule(self::getUserModelClass())
                ]
            ]
        );
    }

    /**
     * @param User|null $user
     * @return ProcessCallbackRequest
     */
    public function setUser(?Model $user): ProcessCallbackRequest
    {
        $this->user = $user;
        return $this;
    }
}
