<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('allocations', function (Blueprint $table) {
            $table->string('estimated_duration')->nullable();
            $table->string('terrain')->nullable();
            $table->string('recommended_for')->nullable();
            $table->text('overview')->nullable();
            $table->text('characteristic')->nullable();
            $table->text('ideal_for')->nullable();
            $table->text('inclusions')->nullable();
            $table->text('good_to_know')->nullable();
            $table->text('visit_request_process')->nullable();
            $table->text('terms_and_condition')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
