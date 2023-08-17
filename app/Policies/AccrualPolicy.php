<?php

namespace App\Policies;

use App\Models\Abonent;
use App\Models\Accrual;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccrualPolicy
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
     * @param  \App\Models\Accrual  $accrual
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Accrual $accrual)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Abonent $abonent)
    {
        return $user->role_id == 1 || in_array($abonent->organization_id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Accrual  $accrual
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Accrual $accrual)
    {
        return $user->role_id == 1 || in_array($accrual->abonent->organization_id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Accrual  $accrual
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Accrual $accrual)
    {
        return $user->role_id == 1 || in_array($accrual->abonent->organization_id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Accrual  $accrual
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Accrual $accrual)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Accrual  $accrual
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Accrual $accrual)
    {
        //
    }
}
