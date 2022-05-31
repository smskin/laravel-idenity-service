<?php

namespace SMSkin\IdentityService\Modules\OAuth\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\LaravelSupport\Rules\InstanceOfRule;
use SMSkin\IdentityService\Modules\OAuth\Enums\DriverEnum;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class CreateCredentialRequest extends \SMSkin\LaravelSupport\BaseRequest
{
    use ClassFromConfig;

    public DriverEnum $driver;
    public string $remoteId;

    /**
     * @var User
     */
    public Model $user;

    public function rules(): array
    {
        return [
            'driver' => [
                'required',
                new InstanceOfRule(DriverEnum::class)
            ],
            'remoteId' => [
                'required'
            ],
            'user' => [
                'required',
                new ExistsEloquentModelRule($this->getUserModelClass())
            ]
        ];
    }

    /**
     * @param string $remoteId
     * @return CreateCredentialRequest
     */
    public function setRemoteId(string $remoteId): CreateCredentialRequest
    {
        $this->remoteId = $remoteId;
        return $this;
    }

    /**
     * @param DriverEnum $driver
     * @return CreateCredentialRequest
     */
    public function setDriver(DriverEnum $driver): CreateCredentialRequest
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * @param User $user
     * @return CreateCredentialRequest
     */
    public function setUser(Model $user): CreateCredentialRequest
    {
        $this->user = $user;
        return $this;
    }
}
