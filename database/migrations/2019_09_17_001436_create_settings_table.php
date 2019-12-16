<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('currency_name', 64)->nullable();
            $table->char('currency_text', 64)->nullable();
            $table->char('currency_symbol', 8)->nullable();
            $table->float('currency_conversation_usd', 14, 2)->nullable();
            $table->text('work_days')->nullable();
            $table->smallInteger('working_days_per_month')->nullable();
            $table->smallInteger('working_hours_per_day')->nullable();
            $table->smallInteger('break_min_per_shift')->nullable();
            $table->smallInteger('overtime_count_after')->nullable();
            $table->smallInteger('overtime_max_hours')->nullable();
            $table->float('overtime_rate_workday', 14, 2)->nullable();
            $table->float('overtime_rate_weekend', 14, 2)->nullable();
            $table->float('overtime_rate_holiday', 14, 2)->nullable();
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
        DB::table('settings')->insert([
            [
                'currency_name'             => 'Malaysian Ringgit',
                'currency_text'             => 'MYR',
                'currency_symbol'           => 'RM',
                'currency_conversation_usd' => 4.00,
                'work_days'                 => null,
                'working_days_per_month'    => 25,
                'working_hours_per_day'     => 8,
                'break_min_per_shift'       => 30,
                'overtime_count_after'      => 30,
                'overtime_max_hours'        => 24,
                'overtime_rate_workday'     => 1.5,
                'overtime_rate_weekend'     => 1.5,
                'overtime_rate_holiday'     => 2.00,
                'active'                    => 1
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('settings');
    }
}
