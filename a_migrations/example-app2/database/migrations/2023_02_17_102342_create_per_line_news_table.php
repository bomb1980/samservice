<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerLineNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('per_line_news', function (Blueprint $table) {
            $table->integer('line_id')->autoIncrement();

            // $table->string('line_id')->nullable();
            $table->string('line_code')->nullable();
            $table->string('linename_abbr')->nullable();
            $table->string('linename_th', 1000)->nullable();
            $table->string('linename_en')->nullable();
            $table->string('linegroup_id')->nullable();
            $table->string('positiontype_id')->nullable();
            $table->string('pertype_id')->nullable();
            $table->string('level_min')->nullable();
            $table->string('level_max')->nullable();
            $table->string('sortorder')->nullable();
            $table->string('flag')->nullable();
            $table->string('std_code')->nullable();
            $table->string('creator')->nullable();
            $table->string('createdate')->nullable();
            $table->string('updateuser')->nullable();
            $table->string('updatedate')->nullable();
            $table->string('create_org')->nullable();
            $table->string('recode_id')->nullable();
            $table->string('is_sync')->nullable();
            $table->string('sync_datetime')->nullable();
            $table->string('sync_status_code')->nullable();
            $table->string('is_delete')->nullable();
            $table->string('update_org')->nullable();
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
        Schema::dropIfExists('per_line_news');
    }
}
