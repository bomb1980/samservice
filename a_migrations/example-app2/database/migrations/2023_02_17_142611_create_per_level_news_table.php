<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerLevelNewsTable extends Migration
{

    public function up()
    {
        Schema::create('per_level_news', function (Blueprint $table) {
            $table->integer('level_id')->autoIncrement();
            $table->string('level_code')->nullable();
            $table->string('level_abbr')->nullable();
            $table->string('levelname_th')->nullable();
            $table->string('levelname_en')->nullable();
            $table->string('positiontype_id')->nullable();
            $table->string('pertype_id')->nullable();
            $table->string('flag_executive')->nullable();
            $table->string('region_calc_flag')->nullable();
            $table->string('pos_value')->nullable();
            $table->string('sortorder')->nullable();
            $table->string('flag')->nullable();
            $table->string('creator')->nullable();
            $table->string('createdate')->nullable();
            $table->string('create_org')->nullable();
            $table->string('updateuser')->nullable();
            $table->string('updatedate')->nullable();
            $table->string('update_org')->nullable();
            $table->string('recode_id')->nullable();
            $table->string('is_sync')->nullable();
            $table->string('sync_datetime')->nullable();
            $table->string('sync_status_code')->nullable();
            $table->string('is_delete')->nullable();
            $table->string('org_owner')->nullable();
            $table->string('org_visible')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_level_news');
    }
}
