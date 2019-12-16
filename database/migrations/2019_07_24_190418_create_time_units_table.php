<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeUnitsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('time_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 32);
            $table->string('description', 255)->nullable();
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
        DB::table('time_units')->insert([
            [
                'name'   => 'Year',
                'active' => 1,
            ],
            [
                'name'   => 'Month',
                'active' => 1,

            ],
            [
                'name'   => 'Week',
                'active' => 1,

            ],
            [
                'name'   => 'Day',
                'active' => 1,

            ],
            [
                'name'   => 'Hour',
                'active' => 1,

            ],
            [
                'name'   => 'Min',
                'active' => 1,

            ],
            [
                'name'   => 'Second',
                'active' => 1,

            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('time_units');
    }
}
