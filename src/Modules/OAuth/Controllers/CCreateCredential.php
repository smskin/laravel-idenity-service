<?php

namespace SMSkin\IdentityService\Modules\OAuth\Controllers;

use SMSkin\IdentityService\Models\UserOAuthCredential;
use SMSkin\IdentityService\Modules\Core\BaseController;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\OAuth\Actions\CreateCredentialContext;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\CredentialWithThisRemoteIdAlreadyExists;
use SMSkin\IdentityService\Modules\OAuth\Requests\CreateCredentialRequest;

class CCreateCredential extends BaseController
{
    protected CreateCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateCredentialRequest::class;

    /**
     * @return $this
     * @throws CredentialWithThisRemoteIdAlreadyExists
     */
    public function execute(): self
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

    private function createContext(): UserOAuthCredential
    {
        return app(CreateCredentialContext::class, [
            'request' => $this->request
        ])->execute()->getResult();
    }
}
