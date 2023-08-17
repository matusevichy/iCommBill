<?php

namespace App\Policies;

use App\Models\Abonent;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

//ToDo using user_limit and is_active
class AbonentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Abonent $abonent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Abonent $abonent)
    {
        return $user->role_id == 1 ||
            in_array($abonent->organization_id, $user->organizations()->allRelatedIds()->toArray()) ||
            $user->id == $abonent->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Organization $organization)
    {
        return $user->role_id == 1 || in_array($organization->id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Abonent $abonent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Abonent $abonent)
    {
        return $user->role_id == 1 ||
            in_array($abonent->organization_id, $user->organizations()->allRelatedIds()->toArray()) ||
            $user->id == $abonent->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Abonent $abonent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Abonent $abonent)
    {
        return $user->role_id == 1 ||
            in_array($abonent->organization_id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Abonent $abonent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Abonent $abonent)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Abonent $abonent
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Abonent $abonent)
    {
        return $user->role_id == 1 ||
            in_array($abonent->organization_id, $user->organizations()->allRelatedIds()->toArray());
    }
}
