<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModifyColumnBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->boolean('from_masungi_reservation')->default(false);
            $table->integer('masungi_user_id')->nullable();
            $table->text('trail_data')->nullable();
            $table->text('other_data')->nullable();
            $table->integer('allocation_id')->nullable()->change();
            $table->integer('destination_id')->nullable()->change();
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
