<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions;

use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\CreateCredentialRequest;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;

class CreateCredentialContext extends BaseAction
{
    protected CreateCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateCredentialRequest::class;

    public function execute(): static
    {
        $context = new UserPhoneCredential();
        $context->user_id = $this->request->user->id;
        $context->phone = $this->request->phone;
        $context->save();

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
}
