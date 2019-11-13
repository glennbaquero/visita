<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('allocation_id')->unsigned()->index();
            $table->string('name');
            $table->decimal('weekend', 9, 2)->default(0);
            $table->decimal('weekday', 9, 2)->default(0);
            $table->decimal('daytour', 9, 2)->default(0);
            $table->decimal('overnight', 9, 2)->default(0);
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
        Schema::dropIfExists('fees');
    }
}
