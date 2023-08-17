<?php

namespace App\Policies;

use App\Models\Abonent;
use App\Models\Saldo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SaldoPolicy
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
     * @param  \App\Models\Saldo  $saldo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Saldo $saldo)
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
     * @param  \App\Models\Saldo  $saldo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Saldo $saldo)
    {
        return $user->role_id == 1 || in_array($saldo->abonent->organization_id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Saldo  $saldo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Saldo $saldo)
    {
        return $user->role_id == 1 || in_array($saldo->abonent->organization_id, $user->organizations()->allRelatedIds()->toArray());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Saldo  $saldo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Saldo $saldo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Saldo  $saldo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Saldo $saldo)
    {
        //
    }
}
