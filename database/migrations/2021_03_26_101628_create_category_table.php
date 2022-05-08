<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name', 64);
            $table->integer('quantity')->length(2)->default(0);
            $table->integer('price')->length(10)->default(0);
            $table->integer('sale_off')->length(2)->default(0);
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
        Schema::dropIfExists('category');
    }
}
