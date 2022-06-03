<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Actions;

use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistVerificationRequest;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;

class RemoveVerification extends BaseAction
{
    protected ExistVerificationRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistVerificationRequest::class;

    public function execute(): static
    {
        $verification = $this->request->verification;
        $verification->delete();
        return $this;
    }
}
