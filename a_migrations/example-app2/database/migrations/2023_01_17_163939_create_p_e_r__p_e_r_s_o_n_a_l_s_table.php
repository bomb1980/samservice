<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePERPERSONALSTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // level_no, level_no_salary, per_type, per_id, per_name, per_cardno, per_surname, per_eng_name, per_eng_surname, per_birthdate, per_startdate, per_occupydate, per_status
        Schema::create('per_personal', function (Blueprint $table) {

            $table->string("level_no")->nullable();
            $table->string("level_no_salary")->nullable();

            $table->decimal('org_id', 20, 2)->default(0)->nullable();


            $table->integer('per_id')->length(20)->autoIncrement();
            $table->integer('pos_id')->length(20)->default(0)->nullable();

            $table->string("dpis6_data", 4000)->nullable();
            $table->string("update_date")->nullable();
            $table->decimal('per_status', 20, 2)->default(0)->nullable();
            $table->decimal('per_gender', 20, 2)->default(0)->nullable();
            $table->decimal('org_id_1', 20, 2)->default(0)->nullable();
            $table->decimal('org_id_2', 20, 2)->default(0)->nullable();
            $table->decimal('org_id_3', 20, 2)->default(0)->nullable();
            $table->decimal('org_id_4', 20, 2)->default(0)->nullable();
            $table->decimal('org_id_5', 20, 2)->default(0)->nullable();
            $table->string("pn_code")->nullable();
            $table->string("ot_code")->nullable();
            $table->string("per_name")->nullable();

            $table->string("per_cardno")->nullable();
            $table->string("per_eng_surname")->nullable();
            $table->string("per_occupydate")->nullable();

            $table->decimal('update_user', 20, 2)->default(0)->nullable();


            $table->integer('bomb')->default(1);

            $table->decimal('per_type', 20, 2)->default(0)->nullable();
            $table->string("per_surname")->nullable();
            $table->string("per_eng_name")->nullable();
            $table->string("per_birthdate")->nullable();
            $table->string("per_startdate")->nullable();
            $table->decimal('poem_id', 20, 2)->default(0)->nullable();
            $table->decimal('per_orgmgt', 20, 2)->default(0)->nullable();
            $table->decimal('per_salary', 20, 2)->default(0)->nullable();
            $table->decimal('per_mgtsalary', 20, 2)->default(0)->nullable();
            $table->decimal('per_spsalary', 20, 2)->default(0)->nullable();
            $table->string("mr_code")->nullable();
            $table->string("per_offno")->nullable();
            $table->string("per_taxno")->nullable();
            $table->string("per_blood")->nullable();
            $table->string("re_code")->nullable();
            $table->string("per_retiredate")->nullable();
            $table->string("per_posdate")->nullable();
            $table->string("per_saldate")->nullable();
            $table->string("pn_code_f")->nullable();
            $table->string("per_fathername")->nullable();
            $table->string("per_fathersurname")->nullable();
            $table->string("pn_code_m")->nullable();
            $table->string("per_mothername")->nullable();
            $table->string("per_mothersurname")->nullable();
            $table->string("per_add1")->nullable();
            $table->string("per_add2")->nullable();
            $table->string("pv_code")->nullable();
            $table->string("mov_code")->nullable();
            $table->decimal('per_ordain', 20, 2)->default(0)->nullable();
            $table->decimal('per_soldier', 20, 2)->default(0)->nullable();
            $table->decimal('per_member', 20, 2)->default(0)->nullable();
            $table->decimal('department_id', 20, 2)->default(0)->nullable();
            $table->decimal('approve_per_id', 20, 2)->default(0)->nullable();
            $table->decimal('replace_per_id', 20, 2)->default(0)->nullable();
            $table->decimal('absent_flag', 20, 2)->default(0)->nullable();
            $table->decimal('poems_id', 20, 2)->default(0)->nullable();
            $table->string("per_hip_flag")->nullable();
            $table->string("per_cert_occ")->nullable();
            $table->string("per_nickname")->nullable();
            $table->string("per_home_tel")->nullable();
            $table->string("per_office_tel")->nullable();
            $table->string("per_fax")->nullable();
            $table->string("per_mobile")->nullable();
            $table->string("per_email")->nullable();
            $table->string("per_file_no")->nullable();
            $table->string("per_bank_account")->nullable();
            $table->decimal('per_id_ref', 20, 2)->default(0)->nullable();
            $table->decimal('per_id_ass_ref', 20, 2)->default(0)->nullable();
            $table->string("per_contact_person")->nullable();
            $table->string("per_remark")->nullable();
            $table->string("per_start_org")->nullable();
            $table->decimal('per_cooperative', 20, 2)->default(0)->nullable();
            $table->string("per_cooperative_no")->nullable();
            $table->string("per_memberdate")->nullable();
            $table->decimal('per_seq_no', 20, 2)->default(0)->nullable();
            $table->decimal('pay_id', 20, 2)->default(0)->nullable();
            $table->string("es_code")->nullable();
            $table->string("pl_name_work")->nullable();
            $table->string("org_name_work")->nullable();
            $table->string("per_docno")->nullable();
            $table->string("per_docdate")->nullable();
            $table->string("per_effectivedate")->nullable();
            $table->string("per_pos_reason")->nullable();
            $table->string("per_pos_year")->nullable();
            $table->string("per_pos_doctype")->nullable();
            $table->string("per_pos_docno")->nullable();
            $table->string("per_pos_org")->nullable();
            $table->string("per_ordain_detail")->nullable();
            $table->string("per_pos_orgmgt")->nullable();
            $table->string("per_pos_docdate")->nullable();
            $table->string("per_pos_desc")->nullable();
            $table->string("per_pos_remark")->nullable();
            $table->string("per_book_no")->nullable();
            $table->string("per_book_date")->nullable();
            $table->decimal('per_contact_count', 20, 2)->default(0)->nullable();
            $table->decimal('per_disability', 20, 2)->default(0)->nullable();
            $table->decimal('pot_id', 20, 2)->default(0)->nullable();
            $table->decimal('per_union', 20, 2)->default(0)->nullable();
            $table->string("per_uniondate")->nullable();
            $table->string("per_job")->nullable();

            $table->decimal('per_union2', 20, 2)->default(0)->nullable();
            $table->string("per_uniondate2")->nullable();
            $table->decimal('per_union3', 20, 2)->default(0)->nullable();
            $table->string("per_uniondate3")->nullable();
            $table->decimal('per_union4', 20, 2)->default(0)->nullable();
            $table->string("per_uniondate4")->nullable();
            $table->decimal('per_union5', 20, 2)->default(0)->nullable();
            $table->string("per_uniondate5")->nullable();
            $table->decimal('per_set_ass', 20, 2)->default(0)->nullable();
            $table->decimal('per_audit_flag', 20, 2)->default(0)->nullable();
            $table->decimal('per_probation_flag', 20, 2)->default(0)->nullable();
            $table->decimal('department_id_ass', 20, 2)->default(0)->nullable();
            $table->string("per_birth_place")->nullable();
            $table->string("per_scar")->nullable();
            $table->decimal('per_renew', 20, 2)->default(0)->nullable();
            $table->string("per_leveldate")->nullable();
            $table->string("per_postdate")->nullable();
            $table->decimal('per_ot_flag', 20, 2)->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_personal');
    }
}
