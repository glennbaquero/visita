<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('book_id')->unsigned()->index();
            $table->integer('special_fee_id')->unsigned()->index()->nullable();
            $table->integer('visitor_type_id')->unsigned()->index();
            $table->integer('nationality_id');
            $table->boolean('main')->default(false);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->date('birthdate');
            $table->string('contact_number');
            $table->softDeletes();
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
        Schema::dropIfExists('guests');
    }
}
