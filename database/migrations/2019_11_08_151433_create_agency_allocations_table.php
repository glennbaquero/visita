<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgencyAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_allocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('allocation_id')->unsigned()->index();
            $table->integer('agency_id')->unsigned()->index();
            $table->string('agency_code');
            $table->string('slot');
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
        Schema::dropIfExists('agency_allocations');
    }
}
