<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('type', 32)->nullable();
            $table->smallInteger('priority')->nullable();
            $table->integer('user_from_id')->unsigned()->nullable();
            $table->integer('user_to_id')->unsigned()->nullable();
            $table->string('topics', 128)->nullable();
            $table->string('title', 255);
            $table->text('body')->nullable();
            $table->boolean('sound')->nullable();
            $table->string('tag', 64)->nullable();
            $table->string('color', 16)->nullable();
            $table->string('icon', 255)->nullable();
            $table->string('click_action', 255)->nullable();
            $table->text('data')->nullable();
            $table->text('table_data')->nullable();
            $table->integer('table_data_id')->unsigned()->nullable();
            $table->char('table', 40)->nullable();
            $table->char('model', 40)->nullable();
            $table->smallInteger('read')->default(0)->nullable();
            $table->string('description', 512)->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
