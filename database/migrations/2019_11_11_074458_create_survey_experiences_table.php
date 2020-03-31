<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('question');
            $table->integer('order')->nullable();
            $table->boolean('answerable')->default(false);
            $table->string('others_placeholder')->nullable();
            $table->boolean('show_other')->default(false);
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
        Schema::dropIfExists('survey_experiences');
    }
}
