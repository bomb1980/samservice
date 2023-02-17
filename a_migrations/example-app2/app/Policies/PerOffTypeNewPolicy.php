<?php

namespace App\Policies;

use App\Models\User;
use App\Models\per_off_type_new;
use Illuminate\Auth\Access\HandlesAuthorization;

class PerOffTypeNewPolicy
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
     * @param  \App\Models\per_off_type_new  $perOffTypeNew
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, per_off_type_new $perOffTypeNew)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\per_off_type_new  $perOffTypeNew
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, per_off_type_new $perOffTypeNew)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\per_off_type_new  $perOffTypeNew
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, per_off_type_new $perOffTypeNew)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\per_off_type_new  $perOffTypeNew
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, per_off_type_new $perOffTypeNew)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\per_off_type_new  $perOffTypeNew
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, per_off_type_new $perOffTypeNew)
    {
        //
    }
}
