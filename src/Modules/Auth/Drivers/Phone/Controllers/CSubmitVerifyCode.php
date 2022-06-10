<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use Illuminate\Support\Str;
use SMSkin\IdentityService\Models\UserPhoneVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions\CreateVerificationContext;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\CreateVerificationContextRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\SendVerifyCodeRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyInitialized;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Sms\Requests\SendMessageRequest;
use SMSkin\IdentityService\Modules\Sms\SmsModule;
use Illuminate\Validation\ValidationException;

class CSubmitVerifyCode extends BaseController
{
    protected SendVerifyCodeRequest|BaseRequest|null $request;

    protected ?string $requestClass = SendVerifyCodeRequest::class;

    /**
     * @return static
     * @throws ValidationException
     * @throws VerificationAlreadyInitialized
     */
    public function execute(): static
    {
        $this->validateState();
        $code = $this->generateVerifyCode();
        $this->createVerificationContext($code);
        $this->submitVerificationCode($code);
        return $this;
    }

    /**
     * @return void
     * @throws VerificationAlreadyInitialized
     */
    private function validateState()
    {
        $exists = UserPhoneVerification::active()->wherePhone($this->request->phone)->exists();
        if ($exists) {
            throw new VerificationAlreadyInitialized();
        }
    }

    private function generateVerifyCode(): string
    {
        return Str::random();
    }

    /**
     * @param string $code
     * @return void
     * @throws ValidationException
     */
    private function createVerificationContext(string $code)
    {
        (new CreateVerificationContext(
            (new CreateVerificationContextRequest())
                ->setPhone($this->request->phone)
                ->setCode($code)
        ))->execute();
    }

    /**
     * @param string $code
     * @return void
     * @throws ValidationException
     */
    private function submitVerificationCode(string $code)
    {
        (new SmsModule)->sendMessage(
            (new SendMessageRequest)
                ->setPhone($this->request->phone)
                ->setMessage('Одноразовый пароль: ' . $code)
        );
    }
}
