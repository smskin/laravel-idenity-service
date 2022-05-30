<?php

namespace SMSkin\IdentityService\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserObserver
{
    public function creating(Model $user)
    {
        if (empty($user->identity_uuid)) {
            $user->identity_uuid = Str::uuid()->toString();
        }
    }

    /**
     * Handle the User "created" event.
     *
     * @param Model $user
     * @return void
     */
    public function created(Model $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param Model $user
     * @return void
     */
    public function updated(Model $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param Model $user
     * @return void
     */
    public function deleted(Model $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param Model $user
     * @return void
     */
    public function restored(Model $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param Model $user
     * @return void
     */
    public function forceDeleted(Model $user)
    {
        //
    }
}
