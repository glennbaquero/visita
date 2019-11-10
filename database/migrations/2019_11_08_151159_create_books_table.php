<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('allocation_id')->unsigned()->index();
            $table->integer('bookable_id');
            $table->string('bookable_type');
            $table->datetime('scheduled_at');
            $table->datetime('checked_in_at');
            $table->datetime('re_scheduled_at');
            $table->integer('status');
            $table->string('agency_code')->nullable();
            $table->integer('total_guest')->default(0);
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
        Schema::dropIfExists('books');
    }
}
