<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions\CreateCredentialContext;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;

class CCreateCredential extends BaseController
{
    protected CreateCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateCredentialRequest::class;

    /**
     * @return static
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function execute(): static
    {
        $this->validateCredentials();
        $context = $this->createCredential();
        $this->result = $context;
        return $this;
    }

    /**
     * @return UserPhoneCredential
     */
    public function getResult(): UserPhoneCredential
    {
        return parent::getResult();
    }

    /**
     * @return void
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     */
    private function validateCredentials()
    {
        $exists = UserPhoneCredential::where('user_id', $this->request->user->id)
            ->wherePhone($this->request->phone)
            ->exists();
        if ($exists) {
            throw new UserAlreadyHasCredentialWithThisIdentify();
        }

        $exists = UserPhoneCredential::where('phone', $this->request->phone)
            ->exists();
        if ($exists) {
            throw new ThisIdentifyAlreadyUsesByAnotherUser();
        }
    }

    /**
     * @return UserPhoneCredential
     * @throws ValidationException
     */
    private function createCredential(): UserPhoneCredential
    {
        return (new CreateCredentialContext($this->request))->execute()->getResult();
    }
}
