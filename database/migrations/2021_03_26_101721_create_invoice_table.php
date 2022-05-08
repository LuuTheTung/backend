<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('invoice_id')->comment('yyyymmdd+hh:mm:ss+userid 202102190305500001');
            $table->integer('total_price')->length(10)->default(0);
            $table->timestamp('created_date')->comment('yyyymmdd 20210219');
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
        Schema::dropIfExists('invoice');
    }
}
