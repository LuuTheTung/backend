<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('mst_company_id');
            $table->string('family_name', 64);
            $table->string('given_name', 64);
            $table->string('email', 256);
            $table->string('password', 512);
            $table->string('phone_number');
            $table->string('address')->nullable();
            $table->integer('state_flg')->length(1)->comment('0:working 1:reject');
            $table->timestamp('start_work_date')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_work_date')->nullable();
            $table->integer('user_flg')->length(1)->comment('0:admin 1:user');
            $table->timestamp('create_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->string('create_user', 128);
            $table->timestamp('update_at')->nullable();
            $table->string('update_user', 128)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
