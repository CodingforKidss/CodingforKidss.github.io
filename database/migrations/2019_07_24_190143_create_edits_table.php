<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('edits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('table', 40)->nullable();
            $table->char('model', 40)->nullable();
            $table->text('form_data')->nullable();
            $table->text('dbInsert')->nullable();
            $table->integer('data_id')->unsigned();
            $table->text('prev_data')->nullable();
            $table->text('new_data')->nullable();
            $table->text('changed_data')->nullable();
            $table->string('action_type', 64)->nullable();
            $table->integer('entryby_id')->unsigned()->nullable();
            $table->smallInteger('active')->default(1);
            $table->string('status', 255)->default('created')->nullable();
            $table->string('comment', 255)->nullable();
            $table->string('api_ver', 8)->nullable();
            $table->string('app_ver', 8)->nullable();
            $table->smallInteger('app_build_ver')->nullable();
            $table->string('u_agent', 255)->nullable();
            $table->text('device_log')->nullable();
            $table->ipAddress('ipAddress')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('edits');
    }
}
