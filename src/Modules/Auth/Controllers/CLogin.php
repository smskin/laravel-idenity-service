<?php

namespace SMSkin\IdentityService\Modules\Auth\Controllers;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidScopes;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UnsupportedDriver;
use SMSkin\IdentityService\Modules\Auth\Requests\LoginRequest;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Validation\ValidationException;

class CLogin extends BaseController
{
    protected LoginRequest|BaseRequest|null $request;

    protected ?string $requestClass = LoginRequest::class;

    /**
     * @return CLogin
     * @throws DisabledDriver
     * @throws InvalidPassword
     * @throws InvalidScopes
     * @throws UnsupportedDriver
     * @throws ValidationException
     */
    public function execute(): static
    {
        $user = $this->getDriver()->login($this->request);
        if ($user) {
            $this->validateUserScopes($this->request->scopes, $user);
        }

        $this->result = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getResult(): Model
    {
        return parent::getResult();
    }

    /**
     * @param array $sourceScopes
     * @param User $user
     * @return void
     * @throws InvalidScopes
     */
    private function validateUserScopes(array $sourceScopes, Model $user)
    {
        $failed = [];
        $scopes = $user->getScopes()->pluck('slug')->toArray();
        foreach ($sourceScopes as $scope) {
            if (!in_array($scope, $scopes)) {
                $failed[] = $scope;
            }
        }
        if (count($failed)) {
            throw new InvalidScopes($failed);
        }
    }
}
