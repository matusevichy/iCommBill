<?php

namespace App\Policies;

use App\Models\OrganizationIncome;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationIncomePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrganizationIncome  $organizationIncome
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, OrganizationIncome $organizationIncome)
    {
        return $user->role_id == 1 ||
            in_array($organizationIncome->organization_id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, $organization )
    {
        return $user->role_id == 1 ||
            in_array($organization->id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrganizationIncome  $organizationIncome
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, OrganizationIncome $organizationIncome)
    {
        return $user->role_id == 1 ||
            in_array($organizationIncome->organization_id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrganizationIncome  $organizationIncome
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, OrganizationIncome $organizationIncome)
    {
        return $user->role_id == 1 ||
            in_array($organizationIncome->organization_id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrganizationIncome  $organizationIncome
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, OrganizationIncome $organizationIncome)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrganizationIncome  $organizationIncome
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, OrganizationIncome $organizationIncome)
    {
        //
    }
}
