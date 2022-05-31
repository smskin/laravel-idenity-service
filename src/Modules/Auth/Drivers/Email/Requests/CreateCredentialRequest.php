<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\LaravelSupport\Rules\InstanceOfRule;
use Carbon\Carbon;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class CreateCredentialRequest extends BaseRequest
{
    use ClassFromConfig;

    /**
     * @var User
     */
    public Model $user;
    public string $email;
    public string $password;
    public ?Carbon $verifiedAt = null;

    public function rules(): array
    {
        return [
            'user' => [
                'required',
                new ExistsEloquentModelRule($this->getUserModelClass())
            ],
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required'
            ],
            'validatedAt' => [
                'nullable',
                new InstanceOfRule(Carbon::class)
            ]
        ];
    }

    /**
     * @param string $email
     * @return CreateCredentialRequest
     */
    public function setEmail(string $email): CreateCredentialRequest
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     * @return CreateCredentialRequest
     */
    public function setPassword(string $password): CreateCredentialRequest
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param Carbon|null $verifiedAt
     * @return CreateCredentialRequest
     */
    public function setVerifiedAt(?Carbon $verifiedAt): CreateCredentialRequest
    {
        $this->verifiedAt = $verifiedAt;
        return $this;
    }

    /**
     * @param Model $user
     * @return CreateCredentialRequest
     */
    public function setUser(Model $user): CreateCredentialRequest
    {
        $this->user = $user;
        return $this;
    }
}
