<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerPositionhisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('per_positionhis', function (Blueprint $table) {



            $table->id();
            $table->string("pn_code")->nullable();
            $table->string("pn_shortname")->nullable();
            $table->string("pn_name")->nullable();
            $table->string("pn_eng_name")->nullable();
            $table->string("pn_active")->nullable();
            $table->string("update_user")->nullable();
            $table->string("update_date")->nullable();
            $table->string("rank_flag")->nullable();
            $table->string("pn_seq_no")->nullable();
            $table->string("pn_othername")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_positionhis');
    }
}
