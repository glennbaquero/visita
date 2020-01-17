<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('book_id')->unsigned()->index();
            $table->decimal('conservation_fee', 9, 2);
            $table->decimal('platform_fee', 9, 2);
            $table->decimal('transaction_fee', 9, 2)->default(0);
            $table->decimal('sub_total', 9, 2);
            $table->decimal('grand_total', 9, 2);
            $table->boolean('is_paypal_payment')->default(true); // false bank deposit
            $table->string('payment_code')->nullable(); // nullable !is_paypal_payment
            $table->string('reference_code')->nullable(); 
            $table->string('bank_deposit_slip')->nullable(); // !is_paypal_payment && is_approved upload deposit slip
            $table->boolean('is_approved')->default(false); // !is_paypal_payment approved first of admin
            $table->boolean('is_paid')->default(false); // !is_paypal_payment approval of admin
            $table->integer('deposit_slip_approve')->default(0); // 2 - rejected, 1 - approved, 0 - for confirmation
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
        Schema::dropIfExists('invoices');
    }
}
