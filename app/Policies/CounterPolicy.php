<?php

namespace App\Policies;

use App\Models\Abonent;
use App\Models\Counter;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CounterPolicy
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
     * @param \App\Models\Counter $counter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Counter $counter)
    {
        return $user->role_id == 1 ||
            in_array($counter->abonent->organization_id, $user->organizations()->allRelatedIds()->toArray()) ||
            $user->id == $counter->abonent->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Abonent $abonent)
    {
        return $user->role_id == 1 || in_array($abonent->organization_id,
                $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Counter $counter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Counter $counter)
    {
        return $user->role_id == 1 || in_array($counter->abonent->organization_id,
                $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Counter $counter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Counter $counter)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Counter $counter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Counter $counter)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Counter $counter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Counter $counter)
    {
        //
    }
}
