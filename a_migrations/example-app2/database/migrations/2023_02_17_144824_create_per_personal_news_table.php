<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerPersonalNewsTable extends Migration
{

    public function up()
    {


        if( config('database.default')  == 'mysql'  ) {

            Schema::create('per_personal_news', function (Blueprint $table) {
                $table->bigInteger('per_id')->unique();
                $table->string('pertype_id')->nullable();
                $table->string('per_status')->nullable();
                $table->string('organize_id_ass')->nullable();
                $table->string('per_cardno')->nullable();
                $table->integer('pos_id')->length(20)->nullable();
                $table->string('per_name')->nullable();
                $table->string('per_surname')->nullable();
                $table->string('per_level_id')->nullable();
                $table->text('per_pos_desc',)->nullable();
                $table->text("per_pos_doctype",)->nullable();
                $table->text('per_pos_orgmgt',)->nullable();
                $table->text('per_pos_org',)->nullable();
                $table->string('org_owner')->nullable();
                $table->string('d5_per_id')->nullable();
                $table->string('pos_no')->nullable();
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
                $table->string('per_mobile')->nullable();
                $table->string('per_email')->nullable();
                $table->string('per_license_no')->nullable();
                $table->string('per_id_ref')->nullable();
                $table->string('per_nickname')->nullable();
                $table->string('per_pos_docdate')->nullable();
                $table->string('per_pos_remark')->nullable();
                $table->string('per_book_no')->nullable();
                $table->string('per_job')->nullable();
                $table->string('per_ot_flag')->nullable();
                $table->string('per_type_2535')->nullable();
                $table->string('prename_id')->nullable();
                $table->string('prename_th')->nullable();
                $table->string('prename_en')->nullable();
                $table->string('per_eng_name')->nullable();
                $table->string('per_eng_surname')->nullable();
                $table->string('department_id')->nullable();
                $table->string('province_id')->nullable();
                $table->string('movement_id')->nullable();
                $table->string('pay_no')->nullable();
                $table->string('per_orgmgt')->nullable();
                $table->string('posstatus_id')->nullable();
                $table->string('per_salary')->nullable();
                $table->string('hip_flag')->nullable();


            });

            Schema::create('per_personal_news2', function (Blueprint $table) {
                $table->bigInteger('per_id')->unique();

                $table->string('is_sync')->nullable();
                $table->string('sync_datetime')->nullable();
                $table->string('sync_status_code')->nullable();
                $table->string('per_set_ass')->nullable();
                $table->string('organize_id_work')->nullable();
                $table->string('organize_id_kpi')->nullable();
                $table->string('organize_id_salary')->nullable();
                $table->string('create_date')->nullable();
                $table->string('creator')->nullable();
                $table->string('department_id_ass')->nullable();
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
                $table->string('per_level_date')->nullable();
                $table->string('per_line_date')->nullable();

            });
        }
        else {


        Schema::create('per_personal_news', function (Blueprint $table) {
            $table->string('organize_id_ass')->nullable();
            $table->string('per_status')->nullable();
            $table->string('per_cardno')->nullable();
            $table->integer('pos_id')->length(20)->nullable();
            $table->string('per_name')->nullable();
            $table->string('per_surname')->nullable();
            $table->string('per_level_id')->nullable();
            $table->string('pertype_id')->nullable();
            $table->integer('per_id')->length(20)->autoIncrement();
            $table->string('per_pos_desc', 4000)->nullable();
            $table->string("per_pos_doctype", 4000)->nullable();
            $table->string('per_pos_orgmgt', 4000)->nullable();
            $table->string('per_pos_org', 4000)->nullable();
            $table->string('org_owner')->nullable();
            $table->string('d5_per_id')->nullable();
            $table->string('pos_no')->nullable();
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
            $table->string('per_mobile')->nullable();
            $table->string('per_email')->nullable();
            $table->string('per_license_no')->nullable();
            $table->string('per_id_ref')->nullable();
            $table->string('per_nickname')->nullable();
            $table->string('per_pos_docdate')->nullable();
            $table->string('per_pos_remark')->nullable();
            $table->string('per_book_no')->nullable();
            $table->string('per_job')->nullable();
            $table->string('per_ot_flag')->nullable();
            $table->string('per_type_2535')->nullable();
            $table->string('prename_id')->nullable();
            $table->string('prename_th')->nullable();
            $table->string('prename_en')->nullable();
            $table->string('per_eng_name')->nullable();
            $table->string('per_eng_surname')->nullable();
            $table->string('department_id')->nullable();
            $table->string('province_id')->nullable();
            $table->string('movement_id')->nullable();
            $table->string('pay_no')->nullable();
            $table->string('per_orgmgt')->nullable();
            $table->string('posstatus_id')->nullable();
            $table->string('per_salary')->nullable();
            $table->string('hip_flag')->nullable();
            $table->string('is_sync')->nullable();
            $table->string('sync_datetime')->nullable();
            $table->string('sync_status_code')->nullable();
            $table->string('per_set_ass')->nullable();
            $table->string('organize_id_work')->nullable();
            $table->string('organize_id_kpi')->nullable();
            $table->string('organize_id_salary')->nullable();
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
            $table->string('per_level_date')->nullable();
            $table->string('per_line_date')->nullable();



        });


        }

    }



    public function down()
    {
        if( config('database.default')  == 'mysql'  ) {

            Schema::dropIfExists('per_personal_news');
            Schema::dropIfExists('per_personal_news2');
        }
        else {

            Schema::dropIfExists('per_personal_news');
        }

    }


}
