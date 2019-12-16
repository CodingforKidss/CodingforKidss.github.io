<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('googlePlusId', 128)->unique()->nullable();
            $table->string('facebookId', 128)->unique()->nullable();
            $table->string('fb_access_token', 255)->unique()->nullable();
            $table->string('google_access_token', 255)->unique()->nullable();
            $table->string('username', 32)->unique()->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city_id', 255)->nullable();
            $table->char('post_code', 16)->nullable();
            $table->smallInteger('country_id')->nullable();
            $table->char('phone', 32)->unique()->nullable();
            $table->smallInteger('role_id')->unsigned()->nullable();

            $table->string('employee_no', 32)->unique()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->char('gender', 16)->nullable();
            $table->char('religion', 32)->nullable();
            $table->char('blood_group', 4)->nullable();
            $table->char('marital_status', 16)->nullable();
            $table->string('driving_license', 64)->nullable();
            $table->string('passport_no', 64)->nullable();
            $table->string('nid', 64)->nullable();
            $table->smallInteger('nationality_id')->nullable();
            $table->string('emergency_name', 255)->nullable();
            $table->string('emergency_address', 255)->nullable();
            $table->string('emergency_city_id', 255)->nullable();
            $table->char('emergency_post_code', 16)->nullable();
            $table->smallInteger('emergency_country_id')->nullable();
            $table->char('emergency_phone', 32)->nullable();
            $table->smallInteger('department_id')->nullable();
            $table->smallInteger('designation_id')->nullable();
            $table->dateTime('joining_date')->nullable();
            $table->dateTime('resign_date')->nullable();
            $table->float('pay_rate', 14, 2)->nullable();
            $table->smallInteger('pay_rate_unit_type_id')->nullable();
            $table->smallInteger('shift_id')->nullable();
            $table->text('work_days')->nullable();
            $table->char('employement_type', 32)->nullable();
            $table->string('description', 512)->nullable();

            $table->string('photo', 128)->default('avatar.jpg')->nullable();
            $table->smallInteger('branch_id')->unsigned()->nullable();
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
            $table->ipAddress('ipAddress_signup')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'role_id'  => 2,
                'active'   => 0
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}
