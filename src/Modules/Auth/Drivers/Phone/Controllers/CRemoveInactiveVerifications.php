<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use SMSkin\IdentityService\Models\UserPhoneVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions\RemoveVerification;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistVerificationRequest;
use SMSkin\IdentityService\Modules\Core\BaseController;
use Illuminate\Support\Collection;

class CRemoveInactiveVerifications extends BaseController
{
    public function execute(): self
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

    private function removeVerification(UserPhoneVerification $verification)
    {
        app(RemoveVerification::class, [
            'request' => (new ExistVerificationRequest)
                ->setVerification($verification)
        ])->execute();
    }
}
