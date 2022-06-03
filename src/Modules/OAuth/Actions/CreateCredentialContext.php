<?php

namespace SMSkin\IdentityService\Modules\OAuth\Actions;

use SMSkin\IdentityService\Models\UserOAuthCredential;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\OAuth\Requests\CreateCredentialRequest;

class CreateCredentialContext extends BaseAction
{
    protected CreateCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateCredentialRequest::class;

    public function execute(): static
    {
        $context = new UserOAuthCredential();
        $context->driver = $this->request->driver;
        $context->remote_id = $this->request->remoteId;
        $context->user_id = $this->request->user->id;
        $context->save();

        $this->result = $context;
        return $this;
    }

    /**
     * @return UserOAuthCredential
     */
    public function getResult(): UserOAuthCredential
    {
        return parent::getResult();
    }
}
