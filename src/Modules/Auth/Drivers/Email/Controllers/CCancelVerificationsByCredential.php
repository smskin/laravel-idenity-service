<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Models\UserEmailVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistVerificationRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyCanceled;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Support\Collection;

class CCancelVerificationsByCredential extends BaseController
{
    protected ExistCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistCredentialRequest::class;

    public function execute(): static
    {
        $verifications = $this->getVerifications();
        foreach ($verifications as $verification) {
            $this->cancelVerification($verification);
        }
        return $this;
    }

    /**
     * @return Collection<UserEmailCredential>
     */
    private function getVerifications(): Collection
    {
        return UserEmailVerification::active()
            ->whereUserId($this->request->credential->user_id)
            ->whereEmail($this->request->credential->email)
            ->get();
    }

    private function cancelVerification(UserEmailVerification $verification)
    {
        try {
            app(CMarkVerificationAsCanceled::class, [
                'request' => (new ExistVerificationRequest)
                    ->setVerification($verification)
            ])->execute();
        } catch (VerificationAlreadyCanceled) {
            // not possible
        }
    }
}
