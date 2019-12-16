<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_method', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 32);
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
        DB::table('payment_method')->insert([
            [
                'name' => 'Cash',
                'active' => 1
            ],
            [
                'name' => 'Bank Deposit',
                'active' => 1
            ],
            [
                'name' => 'Internet Banking',
                'active' => 1
            ],
            [
                'name' => 'Mobile Banking',
                'active' => 1
            ],
            [
                'name' => 'Paypal',
                'active' => 1
            ],
            [
                'name' => 'Cheque',
                'active' => 1
            ],
            [
                'name' => 'Others',
                'active' => 1
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_method');
    }
}
