<?php

namespace SMSkin\IdentityService\Policies;

use Illuminate\Auth\Access\Response;
use SMSkin\IdentityService\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use SMSkin\IdentityServiceClient\Enums\Scopes;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->can(Scopes::IDENTITY_SERVICE_MANAGE_USER);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function view(User $user, User $model): Response|bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function update(User $user, User $model): Response|bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function delete(User $user, User $model): Response|bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function restore(User $user, User $model): Response|bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function forceDelete(User $user, User $model): Response|bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can impersonate by another user.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function impersonate(User $user, User $model): Response|bool
    {
        return $user->can(Scopes::IDENTITY_SERVICE_IMPERSONATE);
    }
}
