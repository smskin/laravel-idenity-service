<?php

namespace SMSkin\IdentityService\Modules\Auth\Controllers;

use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\PhoneModule;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\SendVerifyCodeRequest;
use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyInitialized;
use SMSkin\IdentityService\Modules\Auth\Requests\SendPhoneVerificationCodeRequest;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Validation\ValidationException;

class SendPhoneVerificationCode extends BaseController
{
    protected SendPhoneVerificationCodeRequest|BaseRequest|null $request;

    protected ?string $requestClass = SendPhoneVerificationCodeRequest::class;

    /**
     * @return static
     * @throws DisabledDriver
     * @throws VerificationAlreadyInitialized
     * @throws ValidationException
     */
    public function execute(): static
    {
        $this->validateDriver();
        (new PhoneModule)->sendVerifyCode(
            (new SendVerifyCodeRequest)
                ->setPhone($this->request->phone)
        );

        return $this;
    }

    /**
     * @return void
     * @throws DisabledDriver
     */
    private function validateDriver()
    {
        if (!in_array(DriverEnum::PHONE, config('identity-service.modules.auth.auth.drivers', []))) {
            throw new DisabledDriver();
        }
    }
}
