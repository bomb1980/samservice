<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerOffTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('per_off_type',
         function (Blueprint $table) {

             $table->id();
            $table->string("ot_code")->nullable();
            $table->string("ot_name")->nullable();
            $table->string("ot_active")->nullable();
            $table->string("update_user")->nullable();
            $table->string("update_date")->nullable();
            $table->string("ot_seq_no")->nullable();
            $table->string("ot_othername")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_off_type');
    }
}
