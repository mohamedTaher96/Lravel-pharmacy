<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakeupItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makeup_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('code');
            $table->double('precentage');
            $table->date('expiration');
            $table->bigInteger('makeup_id');
            $table->bigInteger('source_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('makeup_items');
    }
}
