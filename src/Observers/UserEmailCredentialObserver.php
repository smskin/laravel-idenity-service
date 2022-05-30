<?php

namespace SMSkin\IdentityService\Observers;

use SMSkin\IdentityService\Models\UserEmailCredential;
use Illuminate\Support\Facades\Hash;

class UserEmailCredentialObserver
{
    public function creating(UserEmailCredential $credential)
    {
        $credential->password = Hash::make($credential->password);
    }

    /**
     * Handle the UserEmailCredential "created" event.
     *
     * @param UserEmailCredential $userEmailCredential
     * @return void
     */
    public function created(UserEmailCredential $userEmailCredential)
    {
        //
    }

    public function updating(UserEmailCredential $credential)
    {
        if (!empty($credential->password))
        {
            $credential->password = Hash::make($credential->password);
        }
    }

    /**
     * Handle the UserEmailCredential "updated" event.
     *
     * @param UserEmailCredential $userEmailCredential
     * @return void
     */
    public function updated(UserEmailCredential $userEmailCredential)
    {
        //
    }

    /**
     * Handle the UserEmailCredential "deleted" event.
     *
     * @param UserEmailCredential $userEmailCredential
     * @return void
     */
    public function deleted(UserEmailCredential $userEmailCredential)
    {
        //
    }

    /**
     * Handle the UserEmailCredential "restored" event.
     *
     * @param UserEmailCredential $userEmailCredential
     * @return void
     */
    public function restored(UserEmailCredential $userEmailCredential)
    {
        //
    }

    /**
     * Handle the UserEmailCredential "force deleted" event.
     *
     * @param UserEmailCredential $userEmailCredential
     * @return void
     */
    public function forceDeleted(UserEmailCredential $userEmailCredential)
    {
        //
    }
}
