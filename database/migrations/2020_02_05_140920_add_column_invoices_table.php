<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('amount_settled', 9, 2)->default(0);
            $table->decimal('balance', 9, 2)->default(0);
            $table->boolean('is_fullpayment')->default(true);
            $table->boolean('is_firstpayment_paid')->default(true);
            $table->boolean('is_secondpayment_paid')->default(true);
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
