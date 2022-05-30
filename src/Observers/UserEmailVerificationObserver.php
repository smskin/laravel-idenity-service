<?php

namespace SMSkin\IdentityService\Observers;

use SMSkin\IdentityService\Models\UserEmailVerification;
use Illuminate\Support\Facades\Hash;

class UserEmailVerificationObserver
{
    public function creating(UserEmailVerification $emailVerification)
    {
        $emailVerification->code = Hash::make($emailVerification->code);
    }

    /**
     * Handle the EmailVerification "created" event.
     *
     * @param UserEmailVerification $emailVerification
     * @return void
     */
    public function created(UserEmailVerification $emailVerification)
    {
        //
    }

    /**
     * Handle the EmailVerification "updated" event.
     *
     * @param UserEmailVerification $emailVerification
     * @return void
     */
    public function updated(UserEmailVerification $emailVerification)
    {
        //
    }

    /**
     * Handle the EmailVerification "deleted" event.
     *
     * @param UserEmailVerification $emailVerification
     * @return void
     */
    public function deleted(UserEmailVerification $emailVerification)
    {
        //
    }

    /**
     * Handle the EmailVerification "restored" event.
     *
     * @param UserEmailVerification $emailVerification
     * @return void
     */
    public function restored(UserEmailVerification $emailVerification)
    {
        //
    }

    /**
     * Handle the EmailVerification "force deleted" event.
     *
     * @param UserEmailVerification $emailVerification
     * @return void
     */
    public function forceDeleted(UserEmailVerification $emailVerification)
    {
        //
    }
}
