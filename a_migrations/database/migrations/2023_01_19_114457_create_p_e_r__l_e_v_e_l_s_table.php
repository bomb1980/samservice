<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePERLEVELSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('per_level', function (Blueprint $table) {
            $table->string("level_no")->nullable();
            $table->string("level_name")->nullable();
            $table->integer("level_active")->default(0)->nullable();

            $table->decimal("update_user")->default(0)->nullable();
            $table->decimal("per_type")->default(0)->nullable();
            $table->string("level_shortname")->nullable();
            $table->integer('id')->autoIncrement();
            $table->decimal("level_seq_no")->default(0)->nullable();
            $table->string("position_type")->nullable();
            $table->string("position_level")->nullable();
            $table->string("level_othername")->nullable();
            $table->string("level_engname")->nullable();
            $table->string("update_date")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_level');
    }
}
