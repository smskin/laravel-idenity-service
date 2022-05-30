<?php

namespace SMSkin\IdentityService\Modules\User\Requests\User;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Core\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class UpdateUserRequest extends BaseRequest
{
    use ClassFromConfig;

    public const NAME = 'name';

    /**
     * @var User
     */
    public Model $user;

    public ?string $name;

    private array $changed = [];

    public function rules(): array
    {
        return [
            'user' => [
                'required',
                new ExistsEloquentModelRule($this->getUserModelClass())
            ],
            'name' => [
                'nullable',
                'string'
            ]
        ];
    }

    /**
     * @param string|null $name
     * @return UpdateUserRequest
     */
    public function setName(?string $name): UpdateUserRequest
    {
        $this->name = $name;
        $this->changed[] = self::NAME;
        return $this;
    }

    /**
     * @param User $user
     * @return UpdateUserRequest
     */
    public function setUser(Model $user): UpdateUserRequest
    {
        $this->user = $user;
        return $this;
    }

    public function isChanged(string $prop): bool
    {
        return in_array($prop, $this->changed);
    }
}
