<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('overview');
            $table->string('code')->nullable();
            $table->integer('capacity_per_day');
            $table->time('operating_hours');
            $table->boolean('status')->default(true);
            $table->text('orientation_module')->nullable();
            $table->text('terms_conditions');
            $table->text('visitor_policies');
            $table->longText('icon')->nullable();
            $table->text('contact_us');
            $table->text('fees');
            $table->longText('how_to_get_here');

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
        Schema::dropIfExists('destinations');
    }
}
