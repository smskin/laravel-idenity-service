<?php

namespace SMSkin\IdentityService\Observers;

use SMSkin\IdentityService\Models\UserPhoneVerification;
use Illuminate\Support\Facades\Hash;

class PhoneVerificationObserver
{
    public function creating(UserPhoneVerification $phoneVerification)
    {
        $phoneVerification->code = Hash::make($phoneVerification->code);
    }

    /**
     * Handle the EmailVerification "created" event.
     *
     * @param UserPhoneVerification $phoneVerification
     * @return void
     */
    public function created(UserPhoneVerification $phoneVerification)
    {
        //
    }

    /**
     * Handle the EmailVerification "updated" event.
     *
     * @param UserPhoneVerification $phoneVerification
     * @return void
     */
    public function updated(UserPhoneVerification $phoneVerification)
    {
        //
    }

    /**
     * Handle the EmailVerification "deleted" event.
     *
     * @param UserPhoneVerification $phoneVerification
     * @return void
     */
    public function deleted(UserPhoneVerification $phoneVerification)
    {
        //
    }

    /**
     * Handle the EmailVerification "restored" event.
     *
     * @param UserPhoneVerification $phoneVerification
     * @return void
     */
    public function restored(UserPhoneVerification $phoneVerification)
    {
        //
    }

    /**
     * Handle the EmailVerification "force deleted" event.
     *
     * @param UserPhoneVerification $phoneVerification
     * @return void
     */
    public function forceDeleted(UserPhoneVerification $phoneVerification)
    {
        //
    }
}
