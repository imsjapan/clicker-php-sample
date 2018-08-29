<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClickerItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicker_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resource_link_id');
            $table->string('body');
            $table->enum('status', ['NEW', 'ONGOING', 'COMPLETED'] );
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
        Schema::dropIfExists('clicker_items');
    }
}
