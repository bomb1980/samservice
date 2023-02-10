<?php

namespace App\Policies;

use App\Models\OoapTblEmployee;
use App\Models\per_org_ass;
use Illuminate\Auth\Access\HandlesAuthorization;

class PerOrgAssPolicy
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
     * @param  \App\Models\per_org_ass  $perOrgAss
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(OoapTblEmployee $ooapTblEmployee, per_org_ass $perOrgAss)
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
     * @param  \App\Models\per_org_ass  $perOrgAss
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(OoapTblEmployee $ooapTblEmployee, per_org_ass $perOrgAss)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\OoapTblEmployee  $ooapTblEmployee
     * @param  \App\Models\per_org_ass  $perOrgAss
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(OoapTblEmployee $ooapTblEmployee, per_org_ass $perOrgAss)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\OoapTblEmployee  $ooapTblEmployee
     * @param  \App\Models\per_org_ass  $perOrgAss
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(OoapTblEmployee $ooapTblEmployee, per_org_ass $perOrgAss)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\OoapTblEmployee  $ooapTblEmployee
     * @param  \App\Models\per_org_ass  $perOrgAss
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(OoapTblEmployee $ooapTblEmployee, per_org_ass $perOrgAss)
    {
        //
    }
}
