<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Actions\CreateCredentialContext;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;

class CCreateCredential extends BaseController
{
    protected CreateCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateCredentialRequest::class;

    /**
     * @return $this
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     */
    public function execute(): self
    {
        $this->validateCredentials();
        $this->result = $this->createCredential();
        return $this;
    }

    /**
     * @return UserEmailCredential
     */
    public function getResult(): UserEmailCredential
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
        $exists = UserEmailCredential::where('user_id', $this->request->user->id)
            ->whereEmail($this->request->email)
            ->exists();
        if ($exists) {
            throw new UserAlreadyHasCredentialWithThisIdentify();
        }

        $exists = UserEmailCredential::where('email', $this->request->email)
            ->exists();
        if ($exists) {
            throw new ThisIdentifyAlreadyUsesByAnotherUser();
        }
    }

    private function createCredential(): UserEmailCredential
    {
        return app(CreateCredentialContext::class, [
            'request' => $this->request
        ])->execute()->getResult();
    }
}
