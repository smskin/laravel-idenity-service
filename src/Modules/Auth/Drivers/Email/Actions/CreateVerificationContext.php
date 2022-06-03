<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Actions;

use SMSkin\IdentityService\Models\UserEmailVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\CreateVerificationContextRequest;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;

class CreateVerificationContext extends BaseAction
{
    protected CreateVerificationContextRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateVerificationContextRequest::class;

    public function execute(): static
    {
        $context = new UserEmailVerification();
        $context->user_id = $this->request->credential->user_id;
        $context->credential_id = $this->request->credential->id;
        $context->email = $this->request->credential->email;
        $context->code = $this->request->code;
        $context->save();

        $this->result = $context;
        return $this;
    }

    /**
     * @return static
     */
    public function getResult(): static
    {
        return parent::getResult();
    }
}
