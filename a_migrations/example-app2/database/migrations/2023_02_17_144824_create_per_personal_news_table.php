<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerPersonalNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('per_personal_news', function (Blueprint $table) {
            $table->integer('per_id')->length(20)->autoIncrement();
            $table->string('per_pos_org', 4000)->nullable();
            $table->string('per_pos_desc', 4000)->nullable();
            $table->string("per_pos_doctype", 4000)->nullable();
            $table->string('per_contact_person', 4000)->nullable();
            $table->string('per_pos_orgmgt', 4000)->nullable();




            $table->string('org_owner')->nullable();
            $table->string('per_cardno')->nullable();
            $table->string('per_name')->nullable();
            $table->string('per_surname')->nullable();
            $table->string('d5_per_id')->nullable();
            $table->integer('pos_id')->length(20)->nullable();


            $table->string('pos_no')->nullable();
            $table->string('per_status')->nullable();
            $table->string('per_offno')->nullable();
            $table->string('per_renew')->nullable();
            $table->string('per_taxno')->nullable();
            $table->string('per_start_org')->nullable();
            $table->string('per_startdate')->nullable();
            $table->string('per_occupydate')->nullable();
            $table->string('per_effectivedate')->nullable();
            $table->string('per_gender')->nullable();
            $table->string('blood_id')->nullable();
            $table->string('scar')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('is_ordain')->nullable();
            $table->string('ordain_date')->nullable();
            $table->string('ordain_detail')->nullable();
            $table->string('is_disability')->nullable();
            $table->string('is_soldier_service')->nullable();
            $table->string('per_saldate')->nullable();
            $table->string('probation_startdate')->nullable();
            $table->string('probation_enddate')->nullable();
            $table->string('probation_passdate')->nullable();
            $table->string('per_posdate')->nullable();
            $table->string('approve_per_id')->nullable();
            $table->string('replace_per_id')->nullable();
            $table->string('absent_flag')->nullable();
            $table->string('level_no_salary')->nullable();
            $table->string('per_mobile')->nullable();
            $table->string('per_email')->nullable();
            $table->string('per_file_no')->nullable();
            $table->string('per_bank_account')->nullable();
            $table->string('per_license_no')->nullable();
            $table->string('per_id_ref')->nullable();
            $table->string('per_nickname')->nullable();
            $table->string('per_id_ass_ref')->nullable();
            $table->string('per_cooperative')->nullable();
            $table->string('per_cooperative_no')->nullable();
            $table->string('per_seq_no')->nullable();
            $table->string('per_pos_reason')->nullable();
            $table->string('per_pos_year')->nullable();
            $table->string('per_remark')->nullable();
            $table->string('per_pos_docno')->nullable();
            $table->string('per_pos_docdate')->nullable();
            $table->string('per_pos_remark')->nullable();
            $table->string('per_book_no')->nullable();
            $table->string('per_book_date')->nullable();
            $table->string('per_contract_count')->nullable();
            $table->string('disability_id')->nullable();
            $table->string('per_job')->nullable();
            $table->string('is_auditor')->nullable();
            $table->string('per_ot_flag')->nullable();
            $table->string('per_type_2535')->nullable();
            $table->string('prename_id')->nullable();
            $table->string('prename_th')->nullable();
            $table->string('prename_en')->nullable();
            $table->string('per_eng_name')->nullable();
            $table->string('per_eng_surname')->nullable();
            $table->string('married_id')->nullable();
            $table->string('religion_id')->nullable();
            $table->string('pertype_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('province_id')->nullable();
            $table->string('movement_id')->nullable();
            $table->string('pay_no')->nullable();
            $table->string('per_orgmgt')->nullable();
            $table->string('per_level_id')->nullable();
            $table->string('posstatus_id')->nullable();
            $table->string('probation_flag')->nullable();
            $table->string('per_salary')->nullable();
            $table->string('per_mgtsalary')->nullable();
            $table->string('per_spsalary')->nullable();
            $table->string('retired_date')->nullable();
            $table->string('nbs_flag')->nullable();
            $table->string('hip_flag')->nullable();
            $table->string('newwave_flag')->nullable();
            $table->string('tena')->nullable();
            $table->string('per_union')->nullable();
            $table->string('per_uniondate')->nullable();
            $table->string('per_union2')->nullable();
            $table->string('per_uniondate2')->nullable();
            $table->string('per_union3')->nullable();
            $table->string('per_uniondate3')->nullable();
            $table->string('per_union4')->nullable();
            $table->string('per_uniondate4')->nullable();
            $table->string('per_union5')->nullable();
            $table->string('per_uniondate5')->nullable();
            $table->string('per_member')->nullable();
            $table->string('per_memberdate')->nullable();
            $table->string('is_sync')->nullable();
            $table->string('sync_datetime')->nullable();
            $table->string('dcid')->nullable();
            $table->string('sync_status_code')->nullable();
            $table->string('per_set_ass')->nullable();
            $table->string('organize_id_ass')->nullable();
            $table->string('organize_id_work')->nullable();
            $table->string('organize_id_kpi')->nullable();
            $table->string('organize_id_salary')->nullable();
            $table->string('scholar_flag')->nullable();
            $table->string('relocation_type')->nullable();
            $table->string('relocation_name')->nullable();
            $table->string('audit_flag')->nullable();
            $table->string('audit_by')->nullable();
            $table->string('audit_date')->nullable();
            $table->string('department_id_ass')->nullable();
            $table->string('create_date')->nullable();
            $table->string('creator')->nullable();
            $table->string('create_org')->nullable();
            $table->string('update_date')->nullable();
            $table->string('update_user')->nullable();
            $table->string('update_name')->nullable();
            $table->string('allow_sync')->nullable();
            $table->string('edit_req_no')->nullable();
            $table->string('update_org')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('creator_name')->nullable();
            $table->string('audit_name')->nullable();
            $table->string('is_delete')->nullable();
            $table->string('exam_register_id')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_surname')->nullable();
            $table->string('father_prename_th')->nullable();
            $table->string('father_prename_id')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_surname')->nullable();
            $table->string('mother_prename_th')->nullable();
            $table->string('mother_prename_id')->nullable();
            $table->string('is_draft')->nullable();
            $table->string('biometric_id')->nullable();
            $table->string('area_province_id')->nullable();
            $table->string('decoration_date')->nullable();
            $table->string('decoration_id')->nullable();
            $table->string('decoration_th')->nullable();
            $table->string('decoration_abbr')->nullable();
            $table->string('per_level_date')->nullable();
            $table->string('per_line_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_personal_news');
    }
}
