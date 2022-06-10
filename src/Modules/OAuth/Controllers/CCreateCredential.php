<?php

namespace SMSkin\IdentityService\Modules\OAuth\Controllers;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Models\UserOAuthCredential;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\OAuth\Actions\CreateCredentialContext;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\CredentialWithThisRemoteIdAlreadyExists;
use SMSkin\IdentityService\Modules\OAuth\Requests\CreateCredentialRequest;

class CCreateCredential extends BaseController
{
    protected CreateCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateCredentialRequest::class;

    /**
     * @return static
     * @throws CredentialWithThisRemoteIdAlreadyExists
     * @throws ValidationException
     */
    public function execute(): static
    {
        $this->validateState();
        $this->result = $this->createContext();
        return $this;
    }

    /**
     * @return UserOAuthCredential
     */
    public function getResult(): UserOAuthCredential
    {
        return parent::getResult();
    }

    /**
     * @return void
     * @throws CredentialWithThisRemoteIdAlreadyExists
     */
    private function validateState()
    {
        $exists = UserOAuthCredential::where('remote_id', $this->request->remoteId)->exists();
        if ($exists) {
            throw new CredentialWithThisRemoteIdAlreadyExists();
        }
    }

    /**
     * @return UserOAuthCredential
     * @throws ValidationException
     */
    private function createContext(): UserOAuthCredential
    {
        return (new CreateCredentialContext($this->request))->execute()->getResult();
    }
}
