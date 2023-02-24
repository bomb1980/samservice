<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerPositionNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (config('database.default')  == 'mysql') {
            Schema::create('per_position_news', function (Blueprint $table) {
                $table->integer('pos_id')->autoIncrement();
                $table->bigInteger('creator')->nullable();
                $table->integer('sync_status_code')->nullable();
                $table->string('update_date')->nullable();
                $table->string('create_date')->nullable();
                $table->string('sync_datetime')->nullable();
                $table->text('pos_condition')->nullable();
                $table->text('pos_remark')->nullable();
                $table->string('pos_doc_no')->nullable();
                $table->string('pos_date')->nullable();
                $table->string('approve_name')->nullable();
                $table->string('approve_docno')->nullable();
                $table->string('approve_date')->nullable();
                $table->string('pos_get_date')->nullable();
                $table->string('pos_change_date')->nullable();
                $table->string('pos_vacant_date')->nullable();
                $table->string('pos_orgmgt')->nullable();
                $table->string('ppt_code')->nullable();
                $table->string('pos_retire')->nullable();
                $table->string('pos_retire_remark')->nullable();
                $table->string('reserve_flag')->nullable();
                $table->string('pos_reserve_desc')->nullable();
                $table->string('pos_reserve_docno')->nullable();
                $table->string('pos_reserve_date')->nullable();
                $table->string('pos_south')->nullable();
                $table->string('pos_spec')->nullable();
                $table->string('pos_job_description')->nullable();
                $table->string('d5_pg_code')->nullable();
                $table->string('allow_decor')->nullable();
                $table->string('practicetype_id')->nullable();
                $table->string('self_ratio')->nullable();
                $table->string('chief_ratio')->nullable();
                $table->string('friend_ratio')->nullable();
                $table->string('sub_ratio')->nullable();
                $table->string('recruit_plan')->nullable();
                $table->string('exper_skill')->nullable();
                $table->string('work_location_id')->nullable();
                $table->string('governor_flag')->nullable();
                $table->string('province_id')->nullable();
                $table->string('d5_pos_id')->nullable();
                $table->string('org_owner')->nullable();
                $table->string('audit_by')->nullable();
                $table->string('audit_date')->nullable();
                $table->string('create_org')->nullable();
                $table->string('update_org')->nullable();
                $table->string('pos_value')->nullable();
                $table->string('update_name')->nullable();
                $table->string('creator_name')->nullable();
                $table->integer('dcid')->nullable();
                $table->integer('pertype_id')->nullable();
                $table->integer('organize_id')->nullable();
                $table->integer('pos_no')->nullable();
                $table->string('pos_no_name')->nullable();
                $table->decimal('pos_salary',20,2)->nullable()->comment();
                $table->decimal('pos_mgtsalary',20,2)->nullable()->comment();
                $table->decimal('min_salary',20,2)->nullable()->comment();
                $table->decimal('max_salary',20,2)->nullable()->comment();
                $table->decimal('group_salary',20,2)->nullable()->comment();
                $table->integer('pos_status')->nullable();
                $table->integer('pos_seq_no')->nullable();
                $table->integer('pay_no')->nullable();
                $table->integer('line_id')->nullable();
                $table->integer('mposition_id')->nullable();
                $table->integer('colevel_id')->nullable();
                $table->integer('level_id')->nullable();
                $table->integer('level_id_min')->nullable();
                $table->integer('level_id_max')->nullable();
                $table->string('flag_level', 1)->nullable();
                $table->string('audit_flag', 1)->nullable();
                $table->integer('is_sync')->nullable();
                $table->integer('condition_id')->nullable();
                $table->integer('frametype_id')->nullable();
                $table->integer('skill_id')->nullable();
                $table->integer('positionstat_id')->nullable();
                $table->integer('posreserve_id')->nullable();
                $table->bigInteger('update_user')->nullable();

            });

        }
        else {

            Schema::create('per_position_news', function (Blueprint $table) {

                $table->bigInteger('creator')->nullable();

                $table->integer('sync_status_code')->nullable();
                $table->string('update_date')->nullable();
                $table->string('create_date')->nullable();
                $table->string('sync_datetime')->nullable();




                $table->string('pos_condition', 4000)->nullable();
                $table->string('pos_remark', 2000)->nullable();
                $table->string('pos_doc_no')->nullable();
                $table->string('pos_date')->nullable();
                $table->string('approve_name')->nullable();
                $table->string('approve_docno')->nullable();
                $table->string('approve_date')->nullable();
                $table->string('pos_get_date')->nullable();
                $table->string('pos_change_date')->nullable();
                $table->string('pos_vacant_date')->nullable();


                $table->string('pos_orgmgt')->nullable();



                $table->string('ppt_code')->nullable();
                $table->string('pos_retire')->nullable();
                $table->string('pos_retire_remark')->nullable();
                $table->string('reserve_flag')->nullable();
                $table->string('pos_reserve_desc')->nullable();
                $table->string('pos_reserve_docno')->nullable();
                $table->string('pos_reserve_date')->nullable();
                $table->string('pos_south')->nullable();
                $table->string('pos_spec')->nullable();
                $table->string('pos_job_description')->nullable();
                $table->string('d5_pg_code')->nullable();
                $table->string('allow_decor')->nullable();
                $table->string('practicetype_id')->nullable();
                $table->string('self_ratio')->nullable();
                $table->string('chief_ratio')->nullable();
                $table->string('friend_ratio')->nullable();
                $table->string('sub_ratio')->nullable();



                $table->string('recruit_plan')->nullable();
                $table->string('exper_skill')->nullable();
                $table->string('work_location_id')->nullable();
                $table->string('governor_flag')->nullable();
                $table->string('province_id')->nullable();
                $table->string('d5_pos_id')->nullable();
                $table->string('org_owner')->nullable();
                $table->string('audit_by')->nullable();
                $table->string('audit_date')->nullable();
                $table->string('create_org')->nullable();
                $table->string('update_org')->nullable();
                $table->string('pos_value')->nullable();
                $table->string('update_name')->nullable();
                $table->string('creator_name')->nullable();

                $table->integer('pos_id')->autoIncrement();
                $table->integer('dcid')->nullable();
                $table->integer('pertype_id')->nullable();
                $table->integer('organize_id')->nullable();
                $table->integer('pos_no')->nullable();
                $table->string('pos_no_name')->nullable();
                // $table->string('pos_salary')->nullable();

                $table->decimal('pos_salary',20,2)->nullable()->comment();
                $table->decimal('pos_mgtsalary',20,2)->nullable()->comment();
                $table->decimal('min_salary',20,2)->nullable()->comment();
                $table->decimal('max_salary',20,2)->nullable()->comment();
                $table->decimal('group_salary',20,2)->nullable()->comment();


                $table->integer('pos_status')->nullable();
                $table->integer('pos_seq_no')->nullable();
                $table->integer('pay_no')->nullable();
                $table->integer('line_id')->nullable();
                $table->integer('mposition_id')->nullable();
                $table->integer('colevel_id')->nullable();
                $table->integer('level_id')->nullable();
                $table->integer('level_id_min')->nullable();
                $table->integer('level_id_max')->nullable();

                $table->string('flag_level', 1)->nullable();
                $table->string('audit_flag', 1)->nullable();
                $table->integer('is_sync')->nullable();
                $table->integer('condition_id')->nullable();
                $table->integer('frametype_id')->nullable();
                $table->integer('skill_id')->nullable();
                $table->integer('positionstat_id')->nullable();
                $table->integer('posreserve_id')->nullable();
                $table->bigInteger('update_user')->nullable();

            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_position_news');
    }
}
