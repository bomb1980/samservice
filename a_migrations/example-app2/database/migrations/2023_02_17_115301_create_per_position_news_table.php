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

        Schema::create('per_position_news', function (Blueprint $table) {

            $table->integer('pos_id')->autoIncrement();
            $table->string('dcid')->nullable();
            $table->string('pertype_id')->nullable();
            $table->string('organize_id')->nullable();
            $table->string('pos_no')->nullable();
            $table->string('pos_no_name')->nullable();
            $table->string('pos_salary')->nullable();
            $table->string('pos_mgtsalary')->nullable();
            $table->string('min_salary')->nullable();
            $table->string('max_salary')->nullable();
            $table->string('group_salary')->nullable();
            $table->string('pos_condition', 4000)->nullable();
            $table->string('pos_doc_no')->nullable();
            $table->string('pos_remark', 2000)->nullable();
            $table->string('pos_date')->nullable();
            $table->string('approve_name')->nullable();
            $table->string('approve_docno')->nullable();
            $table->string('approve_date')->nullable();
            $table->string('pos_get_date')->nullable();
            $table->string('pos_change_date')->nullable();
            $table->string('pos_vacant_date')->nullable();
            $table->string('pos_status')->nullable();
            $table->string('pos_seq_no')->nullable();
            $table->string('pay_no')->nullable();
            $table->string('pos_orgmgt')->nullable();
            $table->string('line_id')->nullable();
            $table->string('mposition_id')->nullable();
            $table->string('colevel_id')->nullable();
            $table->string('level_id')->nullable();
            $table->string('level_id_min')->nullable();
            $table->string('level_id_max')->nullable();
            $table->string('flag_level')->nullable();
            $table->string('condition_id')->nullable();
            $table->string('frametype_id')->nullable();
            $table->string('skill_id')->nullable();
            $table->string('positionstat_id')->nullable();
            $table->string('audit_flag')->nullable();
            $table->string('ppt_code')->nullable();
            $table->string('pos_retire')->nullable();
            $table->string('pos_retire_remark')->nullable();
            $table->string('reserve_flag')->nullable();
            $table->string('posreserve_id')->nullable();
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
            $table->string('update_user')->nullable();
            $table->string('update_date')->nullable();
            $table->string('is_sync')->nullable();
            $table->string('sync_datetime')->nullable();
            $table->string('sync_status_code')->nullable();
            $table->string('recruit_plan')->nullable();
            $table->string('creator')->nullable();
            $table->string('create_date')->nullable();
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
        });
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
