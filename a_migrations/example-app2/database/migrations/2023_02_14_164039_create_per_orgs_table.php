<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerOrgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {



        Schema::create('per_orgs', function (Blueprint $table) {

            $table->integer('id')->autoIncrement();

            $table->integer('org_id')->nullable();
            $table->string('org_code')->nullable();
            $table->string('org_name')->nullable();
            $table->string('org_short')->nullable();
            $table->string('ol_code')->nullable();
            $table->string('ot_code')->nullable();
            $table->string('org_addr1')->nullable();
            $table->string('org_addr2')->nullable();
            $table->string('org_addr3')->nullable();
            $table->string('ap_code')->nullable();
            $table->string('pv_code')->nullable();
            $table->string('ct_code')->nullable();
            $table->string('org_date')->nullable();
            $table->string('org_job')->nullable();
            $table->string('org_id_ref')->nullable();
            $table->string('org_active')->nullable();
            $table->string('update_user')->nullable();
            $table->string('update_date')->nullable();
            $table->string('org_website')->nullable();
            $table->string('org_seq_no')->nullable();
            $table->string('department_id')->nullable();
            $table->string('org_eng_name')->nullable();
            $table->string('pos_lat')->nullable();
            $table->string('pos_long')->nullable();
            $table->string('org_dopa_code')->nullable();
            $table->string('dt_code')->nullable();
            $table->string('mg_code')->nullable();
            $table->string('pg_code')->nullable();
            $table->string('org_zone')->nullable();
            $table->string('org_id_ass')->nullable();

            // $table->string("pn_code")->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_orgs');
    }
}
