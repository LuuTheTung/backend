<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_item', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('invoice_id')->comment('yyyymmdd+hh:mm:ss+userid 202102190305500001');
            $table->bigInteger('category_id');
            $table->bigInteger('category_name');
            $table->integer('quantity')->length(2)->default(0);
            $table->integer('price')->length(10)->default(0);
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
        Schema::dropIfExists('invoice_item');
    }
}
