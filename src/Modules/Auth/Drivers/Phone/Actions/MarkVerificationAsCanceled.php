<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions;

use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistVerificationRequest;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;

class MarkVerificationAsCanceled extends BaseAction
{
    protected ExistVerificationRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistVerificationRequest::class;

    public function execute(): static
    {
        $verification = $this->request->verification;
        $verification->is_canceled = true;
        $verification->save();

        return $this;
    }
}
