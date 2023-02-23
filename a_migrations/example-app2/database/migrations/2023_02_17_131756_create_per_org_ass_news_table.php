<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerOrgAssNewsTable extends Migration
{

    public function up()
    {

        Schema::create('per_org_ass_news', function (Blueprint $table) {


            $table->integer('organize_id')->autoIncrement();



            $table->string('org_date')->nullable();
            $table->string('org_start_date')->nullable();
            $table->string('org_end_date')->nullable();
            $table->string('organize_th')->nullable();
            $table->string('organize_en')->nullable();
            $table->string('organize_abbrth')->nullable();
            $table->string('organize_abbren')->nullable();

            $table->string('risk_zone')->nullable();

            $table->string('org_website')->nullable();
            $table->string('org_gps')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('org_dopa_code')->nullable();
            $table->string('ministrygroup_id')->nullable();
            $table->string('sector_id')->nullable();
            $table->string('org_id_ass')->nullable();
            $table->string('org_chart_level')->nullable();
            $table->string('command_no')->nullable();
            $table->string('command_date')->nullable();
            $table->string('canceldate')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('remark')->nullable();
            $table->string('sortorder')->nullable();

            $table->string('createdate')->nullable();
            $table->string('create_org')->nullable();
            $table->string('updateuser')->nullable();
            $table->string('updatedate')->nullable();
            $table->string('update_org')->nullable();
            $table->string('is_sync')->nullable();
            $table->string('sync_datetime')->nullable();
            $table->string('sync_status_code')->nullable();
            $table->string('org_path')->nullable();
            $table->string('org_seq_no')->nullable();
            $table->string('ministry_id')->nullable();
            $table->string('ministry')->nullable();
            $table->string('department_id')->nullable();
            $table->string('department')->nullable();
            $table->string('division_id')->nullable();
            $table->string('division')->nullable();
            $table->string('subdiv1')->nullable();
            $table->string('subdiv2')->nullable();
            $table->string('subdiv3')->nullable();
            $table->string('subdiv4')->nullable();
            $table->string('subdiv5')->nullable();
            $table->string('subdiv6')->nullable();
            $table->string('d5_org_id')->nullable();
            $table->string('org_model_id')->nullable();
            $table->string('org_model_dlt_id')->nullable();
            $table->string('leader_pos_id')->nullable();
            $table->string('org_path_name', 2000)->nullable();



            $table->integer('org_status')->nullable();
            $table->integer('organize_pid')->nullable();
            $table->bigInteger('organize_code')->nullable();

            $table->integer('country_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('amphur_id')->nullable();
            $table->integer('tambon_id')->nullable();
            $table->integer('postcode')->nullable();

            $table->bigInteger('organize_add1')->nullable();
            $table->bigInteger('organize_add2')->nullable();
            $table->bigInteger('organize_add3')->nullable();

            $table->integer('orglevel_id')->nullable();
            $table->integer('orgstat_id')->nullable();
            $table->integer('orgclass_id')->nullable();
            $table->integer('orgtype_id')->nullable();
            $table->integer('organize_job')->nullable();
            $table->integer('org_owner_id')->nullable();
            $table->integer('org_mode')->nullable();
            $table->integer('parent_flag')->nullable();
            $table->integer('creator')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_org_ass_news');
    }
}
