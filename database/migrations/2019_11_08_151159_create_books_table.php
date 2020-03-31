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
            $table->integer('destination_id')->unsigned()->index();
            
            $table->integer('bookable_id');
            $table->string('bookable_type');

            $table->integer('destination_representative_id')->unsigned()->index()->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->dateTime('checked_in_at')->nullable();
            $table->dateTime('re_scheduled_at')->nullable();
            $table->integer('status');
            $table->string('agency_code')->nullable();
            $table->integer('total_guest')->default(0);
            $table->integer('payment_type');
            $table->integer('payment_status')->default(0);
            $table->boolean('is_walkin')->default(0);
            $table->string('qr_code_path');
            $table->string('qr_id');
            $table->string('offline_id')->nullable();
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
