<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerOffTypeNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('per_off_type_news', function (Blueprint $table) {
            $table->integer('pertype_id')->autoIncrement();

            $table->string('pertype_pid')->nullable();
            $table->string('pertype_code')->nullable();
            $table->string('pertype_abbr')->nullable();
            $table->string('pertype')->nullable();
            $table->string('sortorder')->nullable();
            $table->string('flag')->nullable();
            $table->string('creator')->nullable();
            $table->string('createdate')->nullable();
            $table->string('create_org')->nullable();
            $table->string('updateuser')->nullable();
            $table->string('updatedate')->nullable();
            $table->string('recode_id')->nullable();
            $table->string('is_delete')->nullable();
            $table->string('require_cmd')->nullable();
            $table->string('is_sync')->nullable();
            $table->string('sync_datetime')->nullable();
            $table->string('sync_status_code')->nullable();
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
        Schema::dropIfExists('per_off_type_news');
    }
}
