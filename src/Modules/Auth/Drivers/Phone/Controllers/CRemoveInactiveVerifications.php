<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Models\UserPhoneVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions\RemoveVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistVerificationRequest;
use SMSkin\LaravelSupport\BaseController;
use Illuminate\Support\Collection;

class CRemoveInactiveVerifications extends BaseController
{
    /**
     * @return $this
     * @throws ValidationException
     */
    public function execute(): static
    {
        $verifications = $this->getVerifications();
        foreach ($verifications as $verification) {
            $this->removeVerification($verification);
        }
        return $this;
    }

    /**
     * @return Collection<UserPhoneVerification>
     */
    private function getVerifications(): Collection
    {
        return UserPhoneVerification::inactive()->get();
    }

    /**
     * @param UserPhoneVerification $verification
     * @return void
     * @throws ValidationException
     */
    private function removeVerification(UserPhoneVerification $verification)
    {
        (new RemoveVerification(
            (new ExistVerificationRequest)
                ->setVerification($verification)
        ))->execute();
    }
}
