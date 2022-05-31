<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions;

use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistVerificationRequest;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;

class RemoveVerification extends BaseAction
{
    protected ExistVerificationRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistVerificationRequest::class;

    public function execute(): self
    {
        $verification = $this->request->verification;
        $verification->delete();

        return $this;
    }
}
