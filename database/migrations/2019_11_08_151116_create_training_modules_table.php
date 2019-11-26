<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('destination_id')->unsigned()->index();
            $table->string('title');
            $table->text('description');
            $table->integer('type')->default(0); // 0 - image , 1 - video
            $table->string('path');
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
        Schema::dropIfExists('training_modules');
    }
}
