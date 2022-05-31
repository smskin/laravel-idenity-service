<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use Illuminate\Support\Str;
use SMSkin\IdentityService\Models\UserPhoneVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions\CreateVerificationContext;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\CreateVerificationContextRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\SendVerifyCodeRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyInitialized;
use SMSkin\IdentityService\Modules\Core\BaseController;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Sms\Requests\SendMessageRequest;
use SMSkin\IdentityService\Modules\Sms\SmsModule;
use Illuminate\Validation\ValidationException;

class CSubmitVerifyCode extends BaseController
{
    protected SendVerifyCodeRequest|BaseRequest|null $request;

    protected ?string $requestClass = SendVerifyCodeRequest::class;

    /**
     * @return $this
     * @throws ValidationException
     * @throws VerificationAlreadyInitialized
     */
    public function execute(): self
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

    private function createVerificationContext(string $code)
    {
        app(CreateVerificationContext::class, [
            'request' => (new CreateVerificationContextRequest())
                ->setPhone($this->request->phone)
                ->setCode($code)
        ])->execute();
    }

    /**
     * @param string $code
     * @return void
     * @throws ValidationException
     */
    private function submitVerificationCode(string $code)
    {
        app(SmsModule::class)->sendMessage(
            (new SendMessageRequest)
                ->setPhone($this->request->phone)
                ->setMessage('Одноразовый пароль: ' . $code)
        );
    }
}