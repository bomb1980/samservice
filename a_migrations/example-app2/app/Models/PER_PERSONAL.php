<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PER_PERSONAL extends Model
{
    use HasFactory;



    protected $table = 'per_personal';

    protected $primaryKey = 'per_id';

    protected $fillable = [
        'per_cardno', 'level_no', 'level_no_salary', 'per_type', 'ot_code', 'pn_code', 'per_name', 'per_surname', 'per_eng_name', 'per_eng_surname', 'org_id', 'pos_id', 'poem_id', 'per_orgmgt', 'per_salary', 'per_mgtsalary', 'per_spsalary', 'per_gender', 'mr_code', 'per_offno', 'per_taxno', 'per_blood', 're_code', 'per_birthdate', 'per_retiredate', 'per_startdate', 'per_occupydate', 'per_posdate', 'per_saldate', 'pn_code_f', 'per_fathername', 'per_fathersurname', 'pn_code_m', 'per_mothername', 'per_mothersurname', 'per_add1', 'per_add2', 'pv_code', 'mov_code', 'per_ordain', 'per_soldier', 'per_member', 'per_status', 'update_user', 'update_date', 'department_id', 'approve_per_id', 'replace_per_id', 'absent_flag', 'poems_id', 'per_hip_flag', 'per_cert_occ', 'per_nickname', 'per_home_tel', 'per_office_tel', 'per_fax', 'per_mobile', 'per_email', 'per_file_no', 'per_bank_account', 'per_id_ref', 'per_id_ass_ref', 'per_contact_person', 'per_remark', 'per_start_org', 'per_cooperative', 'per_cooperative_no', 'per_memberdate', 'per_seq_no', 'pay_id', 'es_code', 'pl_name_work', 'org_name_work', 'per_docno', 'per_docdate', 'per_effectivedate', 'per_pos_reason', 'per_pos_year', 'per_pos_doctype', 'per_pos_docno', 'per_pos_org', 'per_ordain_detail', 'per_pos_orgmgt', 'per_pos_docdate', 'per_pos_desc', 'per_pos_remark', 'per_book_no', 'per_book_date', 'per_contact_count', 'per_disability', 'pot_id', 'per_union', 'per_uniondate', 'per_job', 'org_id_1', 'org_id_2', 'org_id_3', 'org_id_4', 'org_id_5', 'per_union2', 'per_uniondate2', 'per_union3', 'per_uniondate3', 'per_union4', 'per_uniondate4', 'per_union5', 'per_uniondate5', 'per_set_ass', 'per_audit_flag', 'per_probation_flag', 'department_id_ass', 'per_birth_place', 'per_scar', 'per_renew', 'per_leveldate', 'per_postdate', 'per_ot_flag'
    ];
}
