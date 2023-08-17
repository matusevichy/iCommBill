<?php

namespace App\Policies;

use App\Models\Counter;
use App\Models\CounterValue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CounterValuePolicy
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
     * @param \App\Models\CounterValue $counterValue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CounterValue $counterValue)
    {
        return $user->role_id == 1 ||
            in_array($counterValue->counter->abonent->organization_id,
                $user->organizations()->allRelatedIds()->toArray()) ||
            $user->id == $counterValue->counter->abonent->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Counter $counter)
    {
        return $user->role_id == 1 ||
            in_array($counter->abonent->organization_id,
                $user->organizations()->allRelatedIds()->toArray()) ||
            $user->id == $counter->abonent->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\CounterValue $counterValue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CounterValue $counterValue)
    {
        $counter = Counter::whereId($counterValue->counter_id)->first();
        return ($user->role_id == 1 ||
            in_array($counter->abonent->organization_id,
                $user->organizations()->allRelatedIds()->toArray()) ||
            $user->id == $counter->abonent->user_id) && $counterValue->is_blocked == false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\CounterValue $counterValue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CounterValue $counterValue)
    {
        return ($user->role_id == 1 ||
            in_array($counterValue->counter->abonent->organization_id,
                $user->organizations()->allRelatedIds()->toArray()) ||
            $user->id == $counterValue->counter->abonent->user_id) && $counterValue->is_blocked == false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\CounterValue $counterValue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CounterValue $counterValue)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\CounterValue $counterValue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CounterValue $counterValue)
    {
        //
    }
}
