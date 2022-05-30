<?php

namespace SMSkin\IdentityService\Policies;

use Illuminate\Foundation\Auth\User as Authenticatable;
use SMSkin\IdentityService\Models\ScopeGroup;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ScopeGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param Authenticatable $user
     * @return Response
     */
    public function viewAny(Authenticatable $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param Authenticatable $user
     * @param ScopeGroup $scopeGroup
     * @return Response
     */
    public function view(Authenticatable $user, ScopeGroup $scopeGroup): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param Authenticatable $user
     * @return Response
     */
    public function create(Authenticatable $user): Response
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Authenticatable $user
     * @param ScopeGroup $scopeGroup
     * @return Response
     */
    public function update(Authenticatable $user, ScopeGroup $scopeGroup): Response
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Authenticatable $user
     * @param ScopeGroup $scopeGroup
     * @return Response
     */
    public function delete(Authenticatable $user, ScopeGroup $scopeGroup): Response
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param Authenticatable $user
     * @param ScopeGroup $scopeGroup
     * @return Response
     */
    public function restore(Authenticatable $user, ScopeGroup $scopeGroup): Response
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param Authenticatable $user
     * @param ScopeGroup $scopeGroup
     * @return Response
     */
    public function forceDelete(Authenticatable $user, ScopeGroup $scopeGroup): Response
    {
        return Response::deny();
    }
}
