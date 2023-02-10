<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\Http;


class OoapTblEmployee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // use EncryptedAttribute;

    protected $table = 'ooap_tbl_employees';

    protected $primaryKey = 'emp_id';

    protected $fillable = [
        'emp_citizen_id', 'new_noti', 'division_id', 'division_name', 'province_id', 'role_id', 'from_type', 'title_th', 'fname_th', 'lname_th', 'posit_id', 'posit_name_th', 'positlevel_id', 'level_no', 'positlevel_name', 'direc_id', 'direc_name', 'department_id', 'dept_name_th', 'personal_type_id', 'personal_type_name', 'orgname_id', 'orgname_type', 'prefix_id', 'prefix_name_th', 'dep_div_id', 'start_work', 'birthday', 'address', 'phone', 'email', 'remark', 'myooapsys', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at', 'custom_permission', 'emp_type'
    ];


    static public function updateEmployees( $user )
    {

        $employee_api = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('app.umts_token'),
            'Accept' => 'application/json'
        ])->post(config('app.umts_api') . '/eis/employee_deteil_citizen_id', ['em_citizen_id' => $user->emp_citizen_id])->json();


        if (isset($employee_api[0]['division_id'])) {

            $province_id = NULL;

            $emp_type = 1;

            foreach (OoapMasDivision::getDatas($employee_api[0]['division_id'])->get() as $kp => $vp) {

                $province_id = $vp->province_id;
            }

            if (!empty($province_id)) {
                $emp_type = 2;
            }

            $data_update = [
                'emp_type' => $emp_type,
                'province_id' => $province_id,
                'title_th' => $employee_api[0]['prefix_name_th'],
                'fname_th' => $employee_api[0]['em_name_th'],
                'lname_th' => $employee_api[0]['em_surname_th'],
                'division_id' => $employee_api[0]['division_id'],
                'division_name' => $employee_api[0]['division_name'],
                'department_id' => $employee_api[0]['department_id'],
                'dept_name_th' => $employee_api[0]['dept_name_th'],
                'posit_id' => $employee_api[0]['posit_id'],
                'posit_name_th' => $employee_api[0]['posit_name_th'],

            ];

            $user->update($data_update);
        }
    }

    static public function readNoti()
    {
        return self::where('emp_citizen_id', '=', auth()->user()->emp_citizen_id)->update(['new_noti' => 0]);
    }

    public function users()
    {
        return $this
            ->belongsToMany(OoapTblEmployee::class)
            ->withTimestamps();
    }

    public function roles()
    {

        return $this->hasOne(OoapMasRole::class, 'role_id', 'role_id');
    }

    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('role_name', '=', $role)->first()) {
            return true;
        }
        return false;
    }
}
