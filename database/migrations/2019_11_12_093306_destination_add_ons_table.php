<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DestinationAddOnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destination_add_ons', function (Blueprint $table) {
            $table->integer('destination_id')->unsigned()->index();
            $table->integer('add_on_id')->unsigned()->index();
            $table->primary(['destination_id', 'add_on_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destination_add_ons');
    }
}
