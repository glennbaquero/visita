<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            // $table->decimal('fee', 9, 2)->default(0);
            $table->decimal('weekend_fee', 9, 2)->default(0);
            $table->decimal('weekday_fee', 9, 2)->default(0);
            $table->decimal('daytour_fee', 9, 2)->default(0);
            $table->decimal('overnight_fee', 9, 2)->default(0);
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
        Schema::dropIfExists('visitor_types');
    }
}
