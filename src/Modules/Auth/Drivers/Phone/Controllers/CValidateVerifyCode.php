<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Models\UserPhoneVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistVerificationRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ValidateCredentialsRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyCanceled;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Support\Facades\Hash;

class CValidateVerifyCode extends BaseController
{
    protected ValidateCredentialsRequest|BaseRequest|null $request;

    protected ?string $requestClass = ValidateCredentialsRequest::class;

    /**
     * @return $this
     * @throws ValidationException
     * @throws VerificationAlreadyCanceled
     */
    public function execute(): static
    {
        $verification = $this->getVerification();
        if (!$verification) {
            $this->result = false;
            return $this;
        }

        if (!Hash::check($this->request->code, $verification->code)) {
            $this->result = false;
            return $this;
        }

        $this->cancelVerification($verification);
        $this->result = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function getResult(): bool
    {
        return parent::getResult();
    }

    private function getVerification(): ?UserPhoneVerification
    {
        return UserPhoneVerification::active()->wherePhone($this->request->phone)->first();
    }

    /**
     * @param UserPhoneVerification $verification
     * @return void
     * @throws VerificationAlreadyCanceled
     * @throws ValidationException
     */
    private function cancelVerification(UserPhoneVerification $verification)
    {
        (new CMarkVerificationAsCanceled(
            (new ExistVerificationRequest)
                ->setVerification($verification)
        ))->execute();
    }
}
