<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerOrgAssesTable extends Migration
{


    public function up()
    {
        Schema::create( 'per_org_ass', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->string("pv_code")->nullable();

                $table->string("ot_code")->nullable();

                $table->string("org_dopa_code")->nullable();

                $table->string("org_job")->nullable();

                $table->string("org_addr1")->nullable();
                $table->string("org_addr2")->nullable();
                $table->string("org_addr3")->nullable();
                $table->string("org_seq_no")->nullable();

                $table->string("department_id")->nullable();
                $table->string("org_id_ass")->nullable();

                $table->string("update_date")->nullable();
                $table->string("update_user")->nullable();

                $table->integer("bomb")->default(0);
                $table->integer("org_id")->nullable();
                $table->integer("org_id_")->nullable();
                $table->string("org_code")->nullable();
                $table->string("org_code_")->nullable();
                $table->string("org_name")->nullable();
                $table->string("org_name_")->nullable();
                $table->string("org_short")->nullable();
                $table->string("ol_code")->nullable();

                $table->string("ap_code")->nullable();
                $table->string("ct_code")->nullable();
                $table->string("org_date")->nullable();
                $table->string("org_id_ref")->nullable();
                $table->string("org_active")->nullable();
                $table->string("org_website")->nullable();
                $table->string("org_eng_name")->nullable();
                $table->string("pos_lat")->nullable();
                $table->string("pos_long")->nullable();
                $table->string("dt_code")->nullable();
                $table->string("mg_code")->nullable();
                $table->string("pg_code")->nullable();
                $table->string("org_zone")->nullable();
            }
        );
    }


    public function down()
    {
        Schema::dropIfExists('per_org_ass');
    }
}
