<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions;

use SMSkin\IdentityService\Models\UserPhoneVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\CreateVerificationContextRequest;
use SMSkin\IdentityService\Modules\Core\BaseAction;
use SMSkin\IdentityService\Modules\Core\BaseRequest;

class CreateVerificationContext extends BaseAction
{
    protected CreateVerificationContextRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateVerificationContextRequest::class;

    public function execute(): self
    {
        $context = new UserPhoneVerification();
        $context->phone = $this->request->phone;
        $context->code = $this->request->code;
        $context->save();

        return $this;
    }
}
