<?php

namespace App\Policies;

use App\Models\OoapTblEmployee;
use App\Models\mas_user;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\OoapTblEmployee  $ooapTblEmployee
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(OoapTblEmployee $ooapTblEmployee)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\OoapTblEmployee  $ooapTblEmployee
     * @param  \App\Models\mas_user  $masUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(OoapTblEmployee $ooapTblEmployee, mas_user $masUser)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\OoapTblEmployee  $ooapTblEmployee
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(OoapTblEmployee $ooapTblEmployee)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\OoapTblEmployee  $ooapTblEmployee
     * @param  \App\Models\mas_user  $masUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(OoapTblEmployee $ooapTblEmployee, mas_user $masUser)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\OoapTblEmployee  $ooapTblEmployee
     * @param  \App\Models\mas_user  $masUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(OoapTblEmployee $ooapTblEmployee, mas_user $masUser)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\OoapTblEmployee  $ooapTblEmployee
     * @param  \App\Models\mas_user  $masUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(OoapTblEmployee $ooapTblEmployee, mas_user $masUser)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\OoapTblEmployee  $ooapTblEmployee
     * @param  \App\Models\mas_user  $masUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(OoapTblEmployee $ooapTblEmployee, mas_user $masUser)
    {
        //
    }
}
