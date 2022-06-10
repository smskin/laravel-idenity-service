<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Models\UserEmailVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Actions\RemoveVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistVerificationRequest;
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
     * @return Collection<UserEmailVerification>
     */
    private function getVerifications(): Collection
    {
        return UserEmailVerification::inactive()->get();
    }

    /**
     * @param UserEmailVerification $verification
     * @return void
     * @throws ValidationException
     */
    private function removeVerification(UserEmailVerification $verification)
    {
        (new RemoveVerification(
            (new ExistVerificationRequest)
                ->setVerification($verification)
        ))->execute();
    }
}
