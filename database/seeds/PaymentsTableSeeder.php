<?php

use Illuminate\Database\Seeder;


use App\Models\Payments\Payment;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = [
        	[
        		'name' => 'Bancnet',
        		'fixed_amount' => '25',
        		'code' => 'bn'
        	],
        	[
        		'name' => 'Credit Card/Debit Card',
        		'fixed_amount' => '0.30',
        		'code' => 'cc'
        	],
        	[
        		'name' => 'GCash',
        		'fixed_amount' => '25',
        		'code' => 'gc'
        	],
        	[
        		'name' => '7Eleven',
        		'fixed_amount' => '35',
        		'code' => '7eleven'
        	],
        	[
        		'name' => 'Paypal',
        		'fixed_amount' => '5',
        		'code' => 'pp'
        	],
        ];

        foreach ($payments as $payment) {
        	Payment::create($payment);
        }
    }
}
