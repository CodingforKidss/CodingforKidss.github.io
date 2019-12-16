<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginSessionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('login_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->smallInteger('role_id')->unsigned();
            $table->text('token_id');
            $table->dateTime('time_login')->nullable();
            $table->dateTime('time_logout')->nullable();
            $table->string('description', 512)->nullable();
            $table->string('photo', 64)->nullable();
            $table->smallInteger('branch_id')->unsigned()->nullable();
            $table->integer('entryby_id')->unsigned()->nullable();
            $table->smallInteger('entry_type_id')->unsigned()->nullable();
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
        Schema::dropIfExists('login_sessions');
    }
}
